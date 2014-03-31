各目录说明：

common:
配置文件、通用类库、配置文件
common/lib:
通用类库（也可以把自己的类库放进来）
common/config:
不同环境的配置文件，通过common/env.php指定
common/common.php:
一般每个视图、控制或者模型层都需要调用它

model:
模型层

controller:
控制层

view:
视图层

public:
存放css，js，image


使用说明：
可以使用以下
http://localhost/?c=test/test(如果没有c参数，那么默认路由到CIndex下的index方法)


Change List:
beta1.0

