<template>
  <div class="channel-managemnet">
    <el-card class="box-card">
      <h2>Channels management</h2>
      <el-button type="success" icon="plus" class="add-channel"></el-button>
      <el-table style="width: 100%" border :data="channelData">
        <el-table-column prop="id" label="ID" width="180"></el-table-column>
        <el-table-column prop="name" label="name"></el-table-column>
        <el-table-column label="tools">
          <template scope="scope">
            <el-switch v-model="scope.row.state" on-text="" off-text=""></el-switch>
            <el-button size="small" icon="edit" @click="editChannel"></el-button>
            <el-button size="small" type="danger" icon="delete" @click="removeChannel"></el-button>
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
    }
  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
  .box-card {
    margin: 15px;
    height: 85vh;
    h2 {
      margin-bottom: 5px;
    }
    .add-channel {
      margin-bottom: 15px;
    }
  }
</style>
