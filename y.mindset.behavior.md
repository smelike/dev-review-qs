场景：需要动态添加表单选项

```
如：一本书有多个作者，究竟有多少个作者是未知的。

那你要准备多少个作者输入框呢？

作者输入框，肯定是未知的。所以只能作为动态的。


```

----

### jQuery 时代做法：

```
直接是通过 javaScript 操作 DOM 节点，如：使用 jQuery 将对应 HTML 代码追加到页面中。

```


----

### vue 时代呢？

```

在 node、vue、react、backbone 这大时代中，要怎么呢？

还是添加 DOM 节点，追加 HTML 代码？

如果真的是这样做，那要怎么操作呢？是否有种无法走下的感觉呢？

以 vue 为例，你怎么实现操作DOM？

vue 操作 html 插入指定节点吗？


vue 只是需要操作数据而已。看如下代码：

```

```
export default {
	name: '',
	props: [],
	components: {},
	data () {
		return {
			
		}
	},
	methods: {
		// 添加一个班次
		handleClassAdd () {
		  this.formData.class.push({ up_time: '', off_time: '' })
		},
		// 删除某个班次
		handleDelete (index) {
		  this.formData.class.splice(index, 1)
		  this.changeTime()
		}
	}
}
```

----

### 页面代码

```
<el-row>
	<el-col :span="15">
	  <el-form-item label="班次设置" required>
		<el-button @click="handleClassAdd" type="primary" size="small" icon="el-icon-plus" plain>添加班次</el-button>
	  </el-form-item>
	</el-col>
	<el-col :span="9">
	  <el-form-item label="合计出勤：" class="r-txt">
		<span style="color:#999">{{totalTime}} 小时</span>
	  </el-form-item>
	</el-col>
</el-row>
		  
<el-row v-for="(item, index) in formData.class" :key="index">
	<el-col :span="10" class="time-picker">
	  <el-form-item label="上班时间">
		<el-time-select
		  @change="changeTime"
		  placeholder="请选择"
		  v-model="item.up_time"
		  :picker-options="{
			start: '08:00',
			step: '00:30',
			end: '23:00'
		  }">
		</el-time-select>
	  </el-form-item>
	</el-col>
	<el-col :span="10" class="time-picker">
	  <el-form-item label="下班时间">
		<el-time-select
		  @change="changeTime"
		  placeholder="请选择"
		  v-model="item.off_time"
		  :picker-options="{
			start: '08:00',
			step: '00:30',
			end: '23:00',
			minTime: item.up_time
		  }">
		</el-time-select>
	  </el-form-item>
	</el-col>
	<el-col :span="4">
	  <el-button type="text" class="fr" @click="handleDelete(index)">删除</el-button>
	</el-col>
</el-row>
```