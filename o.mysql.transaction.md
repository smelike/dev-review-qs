# 简介


一个事务，通常对应一个完整的业务。如：银行的转账功能，a 转账给 b, a 扣钱，b 价钱。

一个事务包含一条或多条 DML 语句(insert, update, delete)

一个事务中，要么所有的语句都执行成功，要么都失败。即所有的 DML 语句都成功执行，才修改硬盘数据。



# 事务的四个属性

- 原子性，最小的工作单元，不可再分。事务中的所有操作必须全部成功或全部失败，成功后写入底层数据，失败后回滚 rollback 到事务开启的状态。

- 一致性，事务完成时，必须使所有的数据都保持一致状态，保持数据库的完整性。

- 隔离性，并发事务之间存在隔离，互不干扰。

- 持久性，事务完成之后，对于系统的影响是持久性的。




# 事务隔离级别

- read uncommitted 读未提交

- read committed 读已提交

- repeatable read 可重复读

- serializable 串行化



## 实例

```
create table `bank` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(30) NOT NULL,
	`money` int(255) NOT NULL,
	PRIMARY KEY(`id`)
)


INSERT INTO `bank` VALUES (0, 'zhangsan', 1000),  (0, 'lisi', 2000), (0, 'wangwu', 500), (0, 'zhaoliu', 1300);

mysql> begin;
Query OK, 0 rows affected (0.00 sec)

mysql> update bank set money=money+500 where name='zhangsan';
Query OK, 1 row affected (0.01 sec)

mysql> update bank set money=money-500 where name='lisi';
Query OK, 1 row affected (0.01 sec)

mysql> commit;
Query OK, 0 rows affected (0.00 sec)

mysql> select * from bank;
+----+----------+-------+
| id | name     | money |
+----+----------+-------+
|  1 | zhangsan |  1500 |
|  2 | lisi     |  1500 |
|  3 | wangwu   |   500 |
|  4 | zhaoliu  |  1300 |
+----+----------+-------+
4 rows in set (0.00 sec)
```

