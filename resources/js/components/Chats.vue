<template>
    <div class="row">
        <div class="col-8">
            <div class="card card-default">
                <div class="card-header">Messages</div>
                <div class="card-body p-0">
                    <ul class="list-unstyled" style="height: 300px; overflow-y: scroll">
                        <li class="p-2" v-for="(message ,index) in messages" :key="index">
                            <strong style="font-weight: bolder; color: blue">{{message.user.name}}</strong>
                            {{message.message}}
                        </li>
                    </ul>
                </div>
                <input type="text"
                       v-model="newMessage"

                       name="message"
                       @keyup.enter="sendMessage"
                       placeholder="enter your message...." class="form-control">
            </div>
            <span class="text-muted">is typing .....</span>
        </div>
        <div class="col-4">
            <div class="card card-default">
                <div class="card-header">
                    Active Users
                </div>
                <div class="card-body">
                    <ul>
                        <li class="py-2">Peter</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props : ['user'],
        data() {
            return {
                messages: [],
                newMessage: '',
            }
        },
        created() {
          this.fetchMessages();
          Echo.join('chat')
              .listen('MessageSent',(e) => {
                  this.messages.push(e.message);
              });
        },
        methods: {
            fetchMessages(){
                axios.get('/messages').then(res => {
                    this.messages = res.data
                })
            },
            sendMessage(){
                this.messages.push({
                    user: this.user,
                   message: this.newMessage
                });
                axios.post('/messages', {message: this.newMessage});
                this.newMessage = '';
            }
        }
    }
</script>
