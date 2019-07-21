---
title: lldb 常用命令
date: 2019-07-14 18:10:33
tags:
---

#### 类gdb 的写法
```
1. file a.out	                # 载入可执行文件
2. b main			# 在main处break
3. run				# 启动程序
4. bt				# backtrace ，显示调用栈
5. step			        # 进入方法
6. print argc 	                # 输出参数
7. next 			# 下一步
8. q				# 退出
```

#### lldb的写法(括号内是缩写)
```
1. target create a.out	( tc a.out)			# 载入可执行文件
2. breakpoint set --name main	(br s --name main)      # 在main方法处设置断点
3. process launch (pro la)				# 启动程序
4. thread backtrace					# 打印线程调用栈
5. thread step-in (th step-in)			        # 进入方法
6. expression argc	(p argc)			# 打印变量
7. thread step-over (th step-over)			# 下一步
8. quit (q)					        # 退出
```

能看出来，感觉lldb原生的命令，还是更啰嗦的，不过格式也更清晰 [noun] [verb] [options] [argument]
lldb 支持tab，可以输入target 然后按table 会自动补全，这是一个有意思的feature。

#### 其他命令
1. gui 也是一个很有意思的命令，显示一个IDE的终端界面，只能看，不能操作，操作还是要回到命令行的
2. apropos 增强版的help，apropos frame 可以显示和frame 相关的命令，以及具体作用
3. expression 支持多行写法，先输入expression，然后就可以输入 空行，就可以开始执行语句
4. target modules lookup --address 0x00000, 查看一个地址的代码，用于代码crash确认代码
