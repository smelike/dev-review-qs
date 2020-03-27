### Centos 7 安装 libzip-1.5.1

[原文链接](https://www.bowen-tech.top/articles/detail/28)


> 下载 libzip 压缩包
```
# wget https://libzip.org/download/libzip-1.5.1.tar.gz

```

> 解压

```

tar -zxvf libzip-1.5.1.tar.gz

```

> 进入 libzip-1.5.1 目录

```

cd libzip-1.5.1 

```

> 编译安装

```
mkdir build && cd build && cmake .. && make && make install
```
----

报错：

```
CMake Error at CMakeLists.txt:4 (CMAKE_MINIMUM_REQUIRED):
CMake 3.0.2 or higher is required. You are running version 2.8.12.2
```

----

### 解决办法：

> 卸载系统自带的 cmake

```
yum remove cmake

```

> 下载

```

wget https://github.com/Kitware/CMake/releases/download/v3.13.3/cmake-3.13.3.tar.gz
```

> 解压

```
tar -zxvf cmake-3.13.3.tar.gz

```

> 安装 gcc 等必备程序包

```

yum install -y gcc gcc-c++ make automake

```

> 进入目录

```

cd cmake-3.13.3

```

> 执行编译

```

./bootstrap

```

> 安装 

```

gmake && gmake install

```

> 测试是否安装成功

```
cmake -version

```

> Error

```
# /usr/bin/cmake: No such file or directory

因为直接使用 cmake，系统会到默认的 /usr/bin 中去寻找。
但是 src 中安装的 cmake 是在 /usr/local/bin 中，所以当然找不到。

解决办法：

建一个连接：ln -s /usr/local/bin/cmake	/usr/bin

然后使用 /usr/local/bin/cmake 进行编译

```

> 继续安装 libzip

```
mkdir build && cd build && cmake .. && make && make install
```


