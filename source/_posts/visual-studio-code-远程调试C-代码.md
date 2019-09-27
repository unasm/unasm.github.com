---
title: visual studio code 远程调试C++代码
date: 2019-09-27 14:46:07
tags:
---

神奇的vscode，通过vscode直接调试容器中的代码，可以避免处理环境依赖的问题，大大减少琐事。

主要依赖几个插件，Remote Development, Remote Containers用于链接容器, 然后选择Attach a Exist Container, 自己先通过docker run -d 启动容器，这样能加速，并且环境稳定。

如果希望调试的话，就必须配置launch.js, 可以通过C/C++ Build and Debug Active File 来创建，其中 program 要制定为自己cmake 生成的out文件，args酌情修改

花了很久，主要还是因为对VScode不够了解吧，C的技术栈了解也有限

```
{
    // Use IntelliSense to learn about possible attributes.
    // Hover to view descriptions of existing attributes.
    // For more information, visit: https://go.microsoft.com/fwlink/?linkid=830387
    "version": "0.2.0",
    "configurations": [
        {
            "name": "(gdb) Launch",
            "type": "cppdbg",
            "request": "launch",
            "program": "${workspaceFolder}/build/bin/rpcserver",
            "args": ["${workspaceFolder}/res"],
            "stopAtEntry": false,
            "cwd": "${workspaceFolder}",
            "environment": [],
            "externalConsole": false,
            //"MIMode": "lldb",
            "MIMode": "gdb",
            "setupCommands": [
                {
                    "description": "Enable pretty-printing for gdb",
                    "text": "-enable-pretty-printing",
                    "ignoreFailures": true
                }
            ]
        }
    ]
}
```