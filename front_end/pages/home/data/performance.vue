<template>
  <div class="performance-data" v-loading.body="$store.state.loading">
    <el-card class="box-card">
      <h2>performance data</h2>
      <!--<el-button-group class="el-button-group">-->
        <!--<el-button @click="type='user'">user</el-button>-->
        <!--<el-button @click="type='disease'">disease</el-button>-->
        <!--<el-button @click="type='channel'">channel</el-button>-->
        <!--<el-button @click="type='advisory'">advisory</el-button>-->
      <!--</el-button-group>-->
      <!--<el-table stripe show-summary sum-text="Sum" :data="showData">-->
        <!--<el-table-column-->
          <!--prop="name"-->
          <!--:label="type">-->
        <!--</el-table-column>-->
        <!--<el-table-column-->
          <!--prop="advisory_len"-->
          <!--label="advisory number">-->
        <!--</el-table-column>-->
        <!--<el-table-column-->
          <!--prop="arrive_len"-->
          <!--label="arrive number">-->
        <!--</el-table-column>-->
        <!--<el-table-column-->
          <!--prop="lose_len"-->
          <!--label="lose number">-->
        <!--</el-table-column>-->
        <!--<el-table-column-->
          <!--label="proportion">-->
          <!--<template scope="scope">-->
            <!--<p style="color: #ff0000;">{{getProportion(scope.row)}}</p>-->
          <!--</template>-->
        <!--</el-table-column>-->
      <!--</el-table>-->
    </el-card>
  </div>
</template>

<script>
//  import axios from '../../../config/axios'

  export default {
    name: 'performanceData',
    data () {
      return {
        type: ''
      }
    },
    computed: {
//      showData () {
//        if (this.type === 'user') return this.userGroupData
//        if (this.type === 'disease') return this.diseaseGroupData
//        if (this.type === 'channel') return this.channelGroupData
//        if (this.type === 'advisory') return this.advisoryGroupData
//      }
    },
    methods: {
//      getProportion (data) {
//        if (data['advisory_len'] === 0) return 0
//        return `${(data['arrive_len'] / data['advisory_len']).toFixed(2)}%`
//      }
    },
    mounted () {
//      let self = this
//      !(async function () {
//        [
//          self.userGroupData,
//          self.diseaseGroupData,
//          self.channelGroupData,
//          self.advisoryGroupData
//        ] = await Promise.all([
//          axios.get('/data/group/user'),
//          axios.get('/data/group/disease'),
//          axios.get('/data/group/channel'),
//          axios.get('/data/group/advisory')
//        ])
//        self.type = 'user'
//        self.$store.state.loading = false
//      })()
    }
  }
</script>

<style scoped lang="scss">
  .box-card {
    margin: 15px;
    min-height: 85vh;
    h2 {
      margin-bottom: 25px;
    }
    .el-button-group {
      margin-bottom: 30px;
    }
  }
</style>
