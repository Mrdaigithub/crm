<template>
  <div class="rank" v-loading.body="$store.state.loading">
    <h2>Rank</h2>
    <el-card class="box-card">
      <el-row>
        <el-col :span='8'>
          <el-card class="rank-card">
            <div slot="header" class="clearfix">
              <span>Advisory top</span>
            </div>
            <div class="rank-list">
              <div v-for="advisoryTop of advisoryTopData" class="rank-item">
                {{advisoryTop.username}}
                <el-badge :value="advisoryTop['patient_len']" class="item"></el-badge>
              </div>
            </div>
          </el-card>
        </el-col>
        <el-col :span='8'>
          <el-card class="rank-card">
            <div slot="header" class="clearfix">
              <span>Arrive top</span>
            </div>
            <div class="rank-list">
              <div v-for="arriveTop of arriveTopData" class="rank-item">
                {{arriveTop.username}}
                <el-badge :value="arriveTop['patient_len']" class="item"></el-badge>
              </div>
            </div>
          </el-card>
        </el-col>
        <el-col :span='8'>
          <el-card class="rank-card">
            <div slot="header" class="clearfix">
              <span>Lose top</span>
            </div>
            <div class="rank-list">
              <div v-for="loseTop of loseTopData" class="rank-item">
                {{loseTop.username}}
                <el-badge :value="loseTop['patient_len']" class="item"></el-badge>
              </div>
            </div>
          </el-card>
        </el-col>
      </el-row>
    </el-card>
  </div>
</template>

<script>
  import axios from '../../config/axios'

  export default {
    name: 'rank',
    data () {
      return {
        advisoryTopData: [],
        arriveTopData: [],
        loseTopData: []
      }
    },
    mounted () {
      let self = this
      !(async function () {
        [
          self.advisoryTopData,
          self.arriveTopData,
          self.loseTopData
        ] = await Promise.all([
          axios.get('/ranks/advisory'),
          axios.get('/ranks/arrive'),
          axios.get('/ranks/lose')
        ])
        self.$store.state.loading = false
      })()
    }
  }
</script>

<style scoped lang="scss">
  .rank-card {
    margin: 0 25px;
    .rank-list {
      .rank-item {
        border-bottom: 1px solid #E9E9E9;
        padding: 10px 0;
        color: #5E5E5E;
        font-size: 14px;
        .el-badge {
          float: right
        }
      }
    }
  }
</style>
