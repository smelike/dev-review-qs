import SocketIO from 'socket.io-client'
export default {
  name: 'Play',
  data () {
    return {
      join: false,
      name: null,
      users: null,
      message: null,
      messages: {},
      tableData: []
    }
  },
  created () {
    var socket = SocketIO('http://0.0.0.0:2020')
    this.$socket = socket
    var uid = 123
    socket.on('connect', function () {
      socket.emit('login', uid)
      console.log('login-success:' + uid)
    })
    var that = this
    socket.on('new_msg', function (msg) {
      console.log('receive message:' + msg)
      that.mergeMessage()
      console.log(that.messages)
    })
    socket.on('update_online_count', function (onlineStat) {
      console.log(onlineStat)
    })
  },
  methods: {
    joinChat: function (name) {
      if (name) {
        this.$socket.emit('join', name)
      }
    },
    send: function () {
      if (this.message) {
        console.log('send' + this.message)
        this.$socket.emit('new message', this.message)
        // this.$set('message', null)
      }
    },
    mergeMessage: function () {
      this.messages.push({ msg: 'tommorrow' })
    }
  },
  watch: {
    messages: function () {
      console.log('refersh')
    }
  },
  sockets: {
    users: function (users) {
      this.$set('users', users)
    },
    joined: function () {
      this.$set('join', true)
    },
    messages: function (data) {
      this.$set('messages', data)
    },
    onmessage: function (data) {
      console.log(data)
      this.messages.push({ msg: 'tommorrrot' })
      this.$forceUpdate()
      console.log('heyeyeyey')
    },
    adduser: function (user) {
      this.users.push(user)
    }
  }
}