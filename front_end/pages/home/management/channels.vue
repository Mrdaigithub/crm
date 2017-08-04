<template>
  <div class="channel-managemnet">
    <h2>Channels management</h2>
    <el-card class="box-card">
      <float-button @click.native="addChannel"/>
      <el-table style="width: 100%" border :data="channelData">
        <el-table-column prop="id" label="ID" width="180"></el-table-column>
        <el-table-column prop="name" label="name"></el-table-column>
        <el-table-column label="tools">
          <template scope="scope">
            <el-switch v-model="scope.row.state" on-text="" off-text=""
                       @change="toggleChannelState(scope.$index, scope.row)"></el-switch>
            <el-button size="small" icon="edit"
                       @click="editChannelName(scope.$index, scope.row)">
            </el-button>
            <el-button size="small" type="danger" icon="delete"
                       @click="removeChannel(scope.$index, scope.row)">
            </el-button>
          </template>
        </el-table-column>
      </el-table>
    </el-card>
  </div>
</template>

<script>
  import FloatButton from '~components/FloatButton.vue'
  import axios from '../../../config/axios'
  import qs from 'qs'

  export default {
    name: 'channelManagement',
    components: {
      FloatButton
    },
    data () {
      return {
        channels: []
      }
    },
    computed: {
      channelData () {
        if (!this.channels) return []
        return this.channels.map(channel => {
          channel.state = !!channel.state
          return channel
        })
      }
    },
    methods: {
      addChannel () {
        let self = this
        this.$prompt('Please enter a channel name', 'Tips', {
          showCancelButton: false,
          confirmButtonText: 'Create',
          inputPlaceholder: 'new channel name'
        })
          .then(({value}) => {
            axios.post('/management/channels', qs.stringify({name: value}))
              .then(res => {
                self.channels.push(res.channel)
              })
          })
      },
      editChannelName (index, row) {
        let self = this
        this.$prompt('Please enter a role name', 'Tips', {
          showCancelButton: false,
          confirmButtonText: 'Submit',
          inputValue: row.name
        })
          .then(({value}) => {
            axios.patch(`/management/channels/${row.id}`, qs.stringify({name: value}))
              .then(res => {
                self.channels.splice(index, 1, res.channel)
              })
          })
      },
      toggleChannelState (index, row) {
        axios.patch(`/management/channels/${row.id}`, qs.stringify({
          state: row.state ? 0 : 1
        }))
          .then(res => {
          })
      },
      removeChannel (index, row) {
        let self = this
        axios.delete(`/management/channels/${row.id}`)
          .then(res => {
            self.channels.splice(index, 1)
          })
      }
    },
    mounted () {
      let self = this
      axios.get('/management/channels')
        .then(res => {
          self.channels = res.channels
          self.$store.state.loading = false
        })
    }
  }
</script>

<style scoped lang="scss"></style>
