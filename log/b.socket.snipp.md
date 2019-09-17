import io from 'socket.io-client'

export default {
  data () {
    return {
      isConnected: true,
      inputMessage: '',
      socket: io.connect('http://localhost:2020'),
      messageList: []
    }
  },
  mounted () {
    this.socket.on('new message', (data) => {
      console.log(JSON.stringify(data))
      this.messageList.push(data)
      this.$forceUpdate()
      console.log(this.messageList)
    })
  },
  methods: {
    async publishMessage () {
      if (this.inputMessage && this.isConnected) {
        this.socket.emit('new message', this.inputMessage)
      }
      this.inputMessage = ''
    }
  }
}