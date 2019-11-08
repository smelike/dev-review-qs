在 Windows 2012 中，使用 localhost 与 127.0.0.1 连接 mysql

页面出现数据响应速度，就是不一样的情况。

localhost 就是不如 127.0.0.1 快



> 127.0.0.1

```
'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=127.0.0.1;dbname=dxsys',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
        ],
		
```

> localhost


'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=dxsys',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
        ],

