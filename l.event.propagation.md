
https://vuejs.org/v2/guide/events.html

### Vue 如何阻止事件的冒泡

> 有一个容器，容器本身有一个事件监听，容器内部的元素也存在着事件监听。

> 当点击该元素，事件经冒泡后，会触发容器上的事件。如何阻止事件的冒泡呢？


- wrapper-(event-listener-#1)

	-- inside-(event-listener-#2)
	

----

在容器内部的元素中，添加 v-on:click.stop="doThis".


@20190926
	
	


