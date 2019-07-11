---
title: spark get_json_object的使用方式
date: 2019-07-11 19:28:27
tags:
---

json 扮演的角色越来越重，如何在spark中处理json数据也变得越来越重要
#### 1. 创建dataframe
```
input_parsed = data.select(
	data.recordid,
    func.get_json_object(data.raw, '$.eventName').alias("eventname"),
    func.get_json_object(data.raw, '$.message.input.context.source.platform').alias("source"),
    func.get_json_object(data.raw, '$.message.output.semantic.confidence.score').alias("score")
)
```
这种方式，是直接创建一个dataframe，实现json与dataframe的转化

#### 2. 直接作为筛选条件和select字段
```
select 
	json as raw,
	get_json_object(json, '$.logTime') as logtime,
	get_json_object(json, '$.recordId') as recordid 
	from his.ba_prod_trace_log_new
where day = 20190630 and hour = 19
	and get_json_object(json, '$.module') = 'baserver' and
	get_json_object(json, '$.eventName') = 'sys_input_output'
```
这种方式的好处，就是可以直接在json 之中实现查找，直接定位自己想要的内容，很赞