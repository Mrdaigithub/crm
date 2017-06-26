<template>
  <div class="channel-managemnet">
    <el-card class="box-card">
      <h2>Channels management</h2>
<<<<<<< HEAD
      <el-button type="success" icon="plus" class="add-channel" @click="addChannel"></el-button>
=======
      <el-button type="success" icon="plus" class="add-channel"></el-button>
>>>>>>> dad4ece71b723027a31316569c1b58d4dad1dd74
      <el-table style="width: 100%" border :data="channelData">
        <el-table-column prop="id" label="ID" width="180"></el-table-column>
        <el-table-column prop="name" label="name"></el-table-column>
        <el-table-column label="tools">
          <template scope="scope">
<<<<<<< HEAD
            <el-switch v-model="scope.row.state" on-text="" off-text="" @change="toggleChannelState(scope.$index, scope.row)"></el-switch>
            <el-button size="small" icon="edit"
                       @click="editChannelName(scope.$index, scope.row)">
            </el-button>
            <el-button size="small" type="danger" icon="delete"
                       @click="removeChannel(scope.$index, scope.row)">
            </el-button>
=======
            <el-switch v-model="scope.row.state" on-text="" off-text=""></el-switch>
            <el-button size="small" icon="edit" @click="editChannel"></el-button>
            <el-button size="small" type="danger" icon="delete" @click="removeChannel"></el-button>
>>>>>>> dad4ece71b723027a31316569c1b58d4dad1dd74
          </template>
        </el-table-column>
      </el-table>
    </el-card>
  </div>
</template>

<script>
  import axios from '../../config/axiosConfig'
  import qs from 'qs'

  export default {
    name: 'channelManagement',
    data(){
      return {
<<<<<<< HEAD
        channels: []
      }
    },
    computed: {
      channelData(){
        return this.channels.map(channel => {
          channel.state = channel.state ? true : false;
          return channel
        });
      }
    },
    methods: {
      addChannel(){
        let self = this;
        this.$prompt('Please enter a role name', 'Tips', {
          showCancelButton: false,
          confirmButtonText: 'Create',
          inputPlaceholder: 'new channel name'
        })
          .then(({value}) => {
            axios.post('/management/channels', qs.stringify({name: value}))
              .then(res => {
                self.channels.push(res.channel);
              })
          });
      },
      editChannelName(index, row){
        let self = this;
        this.$prompt('Please enter a role name', 'Tips', {
          showCancelButton: false,
          confirmButtonText: 'Submit',
          inputValue: row.name
        })
          .then(({value}) => {
            axios.patch(`/management/channels/${row.id}`, qs.stringify({name: value}))
              .then(res => {
                self.channels.splice(index, 1, res.channel);
              })
          });
      },
      toggleChannelState(index, row){
          let self = this;
          axios.patch(`/management/channels/${row.id}`, qs.stringify({
            state: row.state ? 0 : 1
          }))
            .then(res=>{})
      },
      removeChannel(index, row){
        let self = this;
        axios.delete(`/management/channels/${row.id}`)
          .then(res => {
            self.channels.splice(index, 1);
          })
      }
    },
    mounted(){
      let self = this;
      axios.get('/management/channels')
        .then(res => {
          self.channels = res.channels;
        })
=======
        channelData: [
          {id: 1, name: 'channel1', state: true},
          {id: 2, name: 'channel2', state: false},
          {id: 3, name: 'channel3', state: false},
          {id: 4, name: 'channel4', state: false}
        ]
      }
    },
    methods: {
      editChannel(){
        console.log('edit');
      },
      removeChannel(){
        console.log('remove');
      }
>>>>>>> dad4ece71b723027a31316569c1b58d4dad1dd74
    }
  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
  .box-card {
    margin: 15px;
<<<<<<< HEAD
    min-height: 85vh;
=======
    height: 85vh;
>>>>>>> dad4ece71b723027a31316569c1b58d4dad1dd74
    h2 {
      margin-bottom: 5px;
    }
    .add-channel {
      margin-bottom: 15px;
    }
  }
</style>
