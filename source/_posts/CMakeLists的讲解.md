---
title: CMakeLists的讲解
date: 2019-09-26 23:32:01
tags:
---

下面是一个系统的cmakelist.txt 文件，我解释下其中的部分，作为自己以后解读cmake的备忘

```
cmake_minimum_required(VERSION 3.0)

// 项目名，必须放在第二位，不然会有CMake Error: Error required internal CMake variable not set这种错误
project( gqa )

// 设置Debug 模式还是Relase模型， 可以用 cmake -DCMAKE_BUILD_TYPE=Debug . 指定Debug模式
IF(NOT CMAKE_BUILD_TYPE)
    SET(CMAKE_BUILD_TYPE Release)
ENDIF()


// message 没有逻辑意义，用于输入提示和变量信息，比如下面，就是用于输出RPC_INCLUDES的变量,
// 其值在rpc-framework-cpp/cmakelist.txt 中 set (RPC_INCLUDES "${_RPC_DIR}/proto" "${_RPC_DIR}/include" ${LIBEVENT_INCLUDE_DIRS}) 设置
message("RPC_INCLUDES=" ${RPC_INCLUDES})
#set(CMAKE_CXX_FLAGS "${CMAKE_CXX_FLAGS} -g -std=c++11 -W")

# 设置CMAKE_CXX_FLAGS 
set(CMAKE_CXX_FLAGS "${CMAKE_CXX_FLAGS} -g -std=c++11 -pthread -Wl,--as-needed")


# 表示本项目并没有include目录
include_directories(
                                   
                   )

                   
# SET 本身只是将后面的值集合起来通过第一个符号来表示
SET(PATH_INCLUDE_DIR ./include )
set (asm_sources 
                ./src/lib/data_utils.cpp
                ./src/lib/test_data_utils.cpp
                ./src/lib/punctuation_model.cpp  
                ./src/lib/punctuation_service.cpp      
                ./src/lib/beam_search_ops.cc
                ./src/lib/beam_search_ops_gpu.cu.cc
                ./src/lib/segmenter.cpp
                ./src/lib/usefultools.cpp 
    )

SET(jsoncpp_sources            
                ./src/lib/json_reader.cpp
                ./src/lib/json_value.cpp
                ./src/lib/json_writer.cpp
                )

# PROJECT_SOURCE_DIR 是自动的, 表示项目的home目录, link_directories 指定要链接的库文件的路径
link_directories(${PROJECT_SOURCE_DIR}/3rdparty)

set(CODE_DIRS ${PROJECT_SOURCE_DIR}/src)

set(SOURCE_DIR ${CODE_DIRS}/lib)
set(TEST_DIR ${CODE_DIRS}/test)

#EXECUTABLE_OUTPUT_PATH  和 LIBRARY_OUTPUT_PATH 是cmake的常量，表示输出的lib和bin的目录，这里控制输出的路径
set(EXECUTABLE_OUTPUT_PATH ${PROJECT_BINARY_DIR}/bin)
set(LIBRARY_OUTPUT_PATH ${PROJECT_BINARY_DIR}/lib)

#add_subdirectory(${SOURCE_DIR} ${LIBRARY_OUTPUT_PATH})
#add_subdirectory(${TEST_DIR} ${EXECUTABLE_OUTPUT_PATH})

# 创建一个共享的库文件，运行时动态链接，还有STATIC，MODULE两种选项，分别表示静态库和模块库
add_library(punctuation_lib SHARED
    ${asm_sources}
    ${jsoncpp_sources}
)

# 为punctuation_lib指定类库，也就是为库文件指定include目录， 
target_include_directories(punctuation_lib PUBLIC
    ${PROJECT_SOURCE_DIR}/include 
    ${PROJECT_SOURCE_DIR}/include/tensorflow/ 
    ${PROJECT_SOURCE_DIR}/include/nsync/
    ${PROJECT_SOURCE_DIR}/include/absl/
    ${PROJECT_SOURCE_DIR}/include/eigen/
    ${PROJECT_SOURCE_DIR}/src/include
    ${PATH_INCLUDE_DIR}
)

# 为指定的类库文件指定它的依赖
target_link_libraries(punctuation_lib 
    libtensorflow_framework.so 
    libtensorflow_cc.so
)

#创建一个可执行的文件，指定它的源码文件, 也就是下面几行都是设置test文件
add_executable(test_tf ${TEST_DIR}/test.cpp)
target_include_directories(test_tf PUBLIC
    ${PROJECT_SOURCE_DIR}/include 
    ${PROJECT_SOURCE_DIR}/include/tensorflow/ 
    ${PROJECT_SOURCE_DIR}/include/nsync/
    ${PROJECT_SOURCE_DIR}/include/absl/
    ${PROJECT_SOURCE_DIR}/include/eigen/
    ${PROJECT_SOURCE_DIR}/src/include
    ${PATH_INCLUDE_DIR}
)
target_link_libraries(test_tf 
    punctuation_lib
)

#获取rpc-framework-cpp 的代码
if(EXISTS "${CMAKE_CURRENT_SOURCE_DIR}/rpc-framework-cpp" AND IS_DIRECTORY "${CMAKE_CURRENT_SOURCE_DIR}/rpc-framework-cpp")
    message(STATUS "dependency grpc already exits")
else()
    execute_process(COMMAND git clone -b v0.1.3-protobuf3.7 https://his_group:Aispeech_hisgroup@git.aispeech.com.cn/his-rpc/rpc-framework-cpp.git ${CMAKE_CURRENT_SOURCE_DIR}/rpc-framework-cpp)
endif()
include(./rpc-framework-cpp/CMakeLists.txt)


# 正式的可执行文件, 也就是每个可执行文件 都有 add_executable/target_include_directories/target_link_libraries 三个步骤,
# 指定include文件和类库，源码文件，比如 target_link_libraries 指定了两个类库，分别由RPC_LIBS和punctuation_lib指定
# 而punctuation_lib是类库，在上面有设置，而RPC_SRC则分别由set(RPC_LIBS event), set(RPC_LIBS ${RPC_LIBS} protobuf grpc++_unsecure gpr) 指定
add_executable(rpcserver rpcserver.cpp ${RPC_SRC})
target_include_directories(rpcserver PUBLIC ${RPC_INCLUDES} ${PROJECT_SOURCE_DIR}/src/include)
target_link_libraries(rpcserver ${RPC_LIBS} punctuation_lib)
#add_executable(rpcclient rpcclient.cpp ${RPC_SRC})
#target_link_libraries(rpcclient  ${RPC_LIBS})
```