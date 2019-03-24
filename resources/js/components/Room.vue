<template>
    <div class="row">
        <div class="col-12">
            <div class="card card-default" style="height: 95%">
                <div class="card-header">{{room.lancer.name === user.name ? room.owner.name : room.lancer.name}}</div>
                <div class="card-body p-0">
                    <ul class="list-unstyled" style="height: 85%; overflow-y: scroll" v-chat-scroll="{always: false, smooth: true}"
                    >
                        <li  style="text-align: center; width: 100%; margin-top: 5px" class="p2"><button class="btn  btn-outline-info" @click="loadMore">Load More</button></li>
                        <li class="p-2"
                            v-for="(message ,index) in messages " :key="index">
                            <!--<strong style="font-weight: bolder; color: blue">{{message.user.name}}</strong>-->
                            <!--<p>-->
                                <!--{{message.message}}-->
                            <!--</p>-->
                            <div :class=" user.id === message.user.id ? ' container darker' : 'container' "
                                :style="{ textAlign: user.id === message.user.id ? ' right' : 'left'}"
                            >
                                <img src="http://amediarts.com/wp-content/uploads/2015/12/user-avatar.png" alt="Avatar"  style="width:100%;"
                                     :class=" user.id === message.user.id ? ' right' : '' "
                                >
                                <p>{{message.message}}</p>
                                <span class="time-left">{{message.created_at}}</span>
                            </div>
                        </li>
                    </ul>
                </div>
                <input type="text"
                       v-model="newMessage"
                       @keydown="TypeEvent"
                       name="message"
                       @keyup.enter="sendMessage"
                       placeholder="enter your message...." class="form-control">
            </div>
            <!--<span class="text-muted">is typing .....</span>-->
        </div>
    </div>
</template>

<script>
    export default {
        props: ['room', 'user','lastt'],
        filters:{
          reverse: function (value) {
              return value.slice().reverse();
          }
        },
        data() {
            return {
                messages: [],
                newMessage: '',
                lp: 0
            }
        },
        created() {
            this.lp = this.lastt;
                axios.get('/room-messages/'+this.room.id + '?page='+this.lp).then(
                    res => {
                        console.log(res);
                        this.messages = res.data.data
                    }
            );
            Echo.private('room-sent.' + this.room.id)
                .listen('MessageRoomSent', (e) => {
                    this.messages.push(e.message)
                });
        },
        methods: {
            loadMore(){
                axios.get('/room-messages/'+this.room.id + '?page='+(this.lp-1)).then(
                    res => {
                        // this.messages.unshift(res.data.data)
                      // this.messages =  this.messages.concat(res.data.data)
                        let ms = res.data.data;
                        for(let i = 0; i < ms.length; i++){
                            this.messages.unshift(ms[i])
                        }
                    }
                );
                this.lp -= 1;
            },
            sendMessage() {
                this.messages.push({
                    user: this.user,
                    message: this.newMessage
                });
                axios.post('/room', {
                    id: this.room.id,
                    message: this.newMessage,
                    user: this.user.id
                });
                this.newMessage = '';
            },
            TypeEvent() {

            }
        }
    }
</script>
<style scoped>
    body {
        margin: 0 auto;
        max-width: 800px;
        padding: 0 20px;
    }

    .container {
        border: 2px solid #dedede;
        background-color: #f1f1f1;
        border-radius: 5px;
        padding: 10px;
        margin: 10px 0;
    }

    .darker {
        border-color: #ccc;
        background-color: #ddd;
    }

    .container::after {
        content: "";
        clear: both;
        display: table;
    }

    .container img {
        float: left;
        max-width: 60px;
        width: 100%;
        margin-right: 20px;
        border-radius: 50%;
    }

    .container img.right {
        float: right;
        margin-left: 20px;
        margin-right:0;
    }

    .time-right {
        float: right;
        color: #aaa;
    }

    .time-left {
        float: left;
        color: #999;
    }
</style>