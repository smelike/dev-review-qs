
https://vuejs.org/v2/guide/events.html

### Vue 如何阻止事件的冒泡

> 有一个容器，容器本身有一个事件监听，容器内部的元素也存在着事件监听。

> 当点击该元素，事件经冒泡后，会触发容器上的事件。如何阻止事件的冒泡呢？


- wrapper-(event-listener-#1)

	-- inside-(event-listener-#2)
	

----

在容器内部的元素中，直接使用 v-on:click.stop="doThis".

> 如：@click.stop="closeChannel(key)"


----

实例代码：

```
 <ul class="chat-list">
  <li
	v-for="(item, key) in chatGroupList"
	:key="key"
	:class="{active: key === selectedChannel }"
	@click.stop="showChannel(key)">
	<a href="javascript:">
	  <span class="el-icon-chat-dot-round channel-icon"></span>
	  <span>{{ item.name }}</span>
	  <span
	  v-if="key > 0"
	  class="close-icon el-icon-close"
	  @click.stop="closeChannel(key)"></span>
	</a>
  </li>
</ul>
```

@20190926
	
	


