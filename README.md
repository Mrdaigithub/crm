# registered crm


## Features

- 登录功能
- token 过期重新获取


## Installing


### Back end


导入sql文件到数据库

更改config.php 参数


### Front end


```bash
$ npm i
$ npm run dev
```


## Error code



| Code          | Description    |
| ------------- |:---------------|
| 40035         |用戶名或密碼不合法|
| 40036         |用戶名或密碼缺失  |
| 46004         |不存在的用户     |
| 46005         |密码错误         |
| 41001         |缺少token参数    |
| 42001         |token超时        |
| 44001         |缺少参数    |
| 40014         |无效的token     |
| 43001         |需要GET请求      |
| 43002         |需要POST请求     |
| 43003         |请求方法错误     |
| 48001         |用户没有权限     |
