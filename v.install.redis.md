[Install redis](https://linuxize.com/post/how-to-install-and-configure-redis-on-centos-7/)

Start by enabling the Remi repository by running the following commands in your SSH terminal:

sudo yum install epel-release yum-utils
sudo yum install http://rpms.remirepo.net/enterprise/remi-release-7.rpm
sudo yum-config-manager --enable remi
Install the Redis package by typing:

sudo yum install redis
Once the installation is completed, start the Redis service and enable it to start automatically on boot with:

sudo systemctl start redis
sudo systemctl enable redis


sudo systemctl status redis

----

```
[root@localhost wbrobot]# sudo systemctl start redis
[root@localhost wbrobot]# sudo systemctl enable redis
Created symlink from /etc/systemd/system/multi-user.target.wants/redis.service to /usr/lib/systemd/system/redis.service.
[root@localhost wbrobot]#

```