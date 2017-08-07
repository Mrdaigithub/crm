# Todo List


- ~~将advistory doctor disease age 移到折叠栏中~~

- ~~折叠栏中加入advistory doctor disease mark frist~~

- ~~添加price统计栏~~

- ~~如果选择 确认已到 状态则自动填充到达时间至sql~~

- ~~添加表格排序功能 可选参数（sex， 各种date，first？）~~

- ~~添加patient表单 加入选择登记人选项 加入 first~~

- ~~添加月排行榜模块 （预约排行TOP, 实到排行TOP, 流失数量TOP, 回访数量TOP）~~
![todo1](./todo1.png-del)

- ~~将新的menu数据更新到seed中~~

- ~~patient 页面翻页 添加loading动画~~

+ ~~添加绩效数据表格~~
  - ~~总体数据 (以月份输出和以年份输出)~~
   ![todo3](./todo3.png-del)

  - ~~客服数据 报表条件(状态：4个基本状态)(统计类型：按年，月，日)~~
   ![todo4](./todo4.png-del)

   - ~~渠道数据 报表条件(状态：4个基本状态)(统计类型：按年，月，日)~~
   ![todo4](./todo6.png-del)

   - ~~医生数据 报表条件(状态：4个基本状态)(统计类型：按年，月，日)~~
   ![todo4](./todo7.png-del)

   - ~~客户状态数据 报表条件(状态：4个基本状态)(统计类型：按年，月，日)~~
   ![todo4](./todo8.png-del)

   - ~~病种数据 报表条件(状态：4个基本状态)(统计类型：按年，月，日)~~
   ![todo4](./todo5.png-del)

- ~~行为日志 模块~~
![todo4](./todo9.png-del)

- ~~patient 添加数据导出功能~~
![todo4](./todo12.png-del)

- ~~patient 添加数据重复提示~~
![todo4](./todo13.png-del)

- 完善错误处理 (patient)

- ~~重构login视图界面~~

- ~~添加自定义滚动条~~

- ~初步完成仪表盘视图~

- 重构权限详情
![todo4](./todo10.png-del)
![todo4](./todo11.png-del)

仪表盘(dashboard)

排行(rank)

客户列表 (patients)
    允许查看登记信息 (patients/info/get)
    允许查看TA人登记信息 (patients/oth/info/get)
    允许查看客户完整电话 (patients/full_tel/get)
    允许使用TA人名义登记 (patients/oth/info/add)
    允许编辑TA人登记信息 (patients/oth/info/edit)
    允许确认已到状态 (patients/arrive_state/edit)
    允许更改除确认外状态 (patients/state/edit)
    允许修改补充客户消费情况 (patients/price/edit)
    允许修改客户预约日期 (patients/advisory_date/edit)
    允许修改客户渠道来源 (patients/channel/edit)
    允许修改客户咨询方式 (patients/advisory/edit)
    允许修改客户预约病种 (patients/disease/edit)
    允许修改客户预约医生 (patients/doctor/edit)
    允许修改客户QQ微信 (patients/wechat/edit)
    允许修改客户搜索关键词 (patients/keyword/edit)
    允许使用导出EXCEL功能 (patients/excel)

数据中心 (data)
  总体数据 (data/total)
  用户数据 (data/user)
  病种数据 (data/disease)
  渠道数据 (data/channel)
  医生数据 (data/doctor)
  客户数据 (data/patient)

信息管理 (info)
  新增病种科室 (info/disease/add)
  删除病种科室 (info/disease/remove)
  修改病种科室 (info/disease/edit)
  新增医生 (info/doctor/add)
  删除医生 (info/disease/remove)
  修改医生 (info/disease/edit)
  新增来源渠道 (info/disease/add)
  删除来源渠道 (info/disease/remove)
  修改来源渠道 (info/disease/edit)
  新增咨询方式 (info/advisory/add)
  删除咨询方式 (info/advisory/remove)
  修改咨询方式 (info/advisory/edit)

人员管理 (users)
  新增角色组 (users/role/add)
  删除角色组 (users/role/remove)
  修改角色组名称 (users/role/edit)
  修改角色组权限 (users/permission/edit)
  新增用户 (users/user/add)
  删除用户 (users/user/remove)
  修改用户 (users/user/edit)

系统管理 (setting)
  查看日志记录 (setting/log)
