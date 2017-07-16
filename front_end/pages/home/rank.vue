<template>
  <div class="rank">
    <el-card class="box-card">
      <h2>Rank</h2>
      <el-row>
        <el-col :span='6'>
          <el-card class="rank-card">
            <div slot="header" class="clearfix">
              <span>Advisory top</span>
            </div>
            <div class="rank-list">
              <div class="rank-item">asdasd<el-badge :value="advisoryTop" class="item"></el-badge></div>
              <div class="rank-item">asdasd<el-badge :value="12" class="item"></el-badge></div>
              <div class="rank-item">asdasd<el-badge :value="12" class="item"></el-badge></div>
              <div class="rank-item">asdasd<el-badge :value="12" class="item"></el-badge></div>
              <div class="rank-item">asdasd<el-badge :value="12" class="item"></el-badge></div>
            </div>
          </el-card>
        </el-col>
        <el-col :span='6'>
          <el-card class="rank-card">
            <div slot="header" class="clearfix">
              <span>Arrive top</span>
            </div>
            <div class="rank-list">
              <div class="rank-item">asdasd<el-badge :value="12" class="item"></el-badge></div>
              <div class="rank-item">asdasd<el-badge :value="12" class="item"></el-badge></div>
              <div class="rank-item">asdasd<el-badge :value="12" class="item"></el-badge></div>
              <div class="rank-item">asdasd<el-badge :value="12" class="item"></el-badge></div>
              <div class="rank-item">asdasd<el-badge :value="12" class="item"></el-badge></div>
              <div class="rank-item">asdasd<el-badge :value="12" class="item"></el-badge></div>
              <div class="rank-item">asdasd<el-badge :value="12" class="item"></el-badge></div>
            </div>
          </el-card>
        </el-col>
        <el-col :span='6'>
          <el-card class="rank-card">
            <div slot="header" class="clearfix">
              <span>Lost top</span>
            </div>
            <div class="rank-list">
              <div class="rank-item">asdasd<el-badge :value="12" class="item"></el-badge></div>
              <div class="rank-item">asdasd<el-badge :value="12" class="item"></el-badge></div>
              <div class="rank-item">asdasd<el-badge :value="12" class="item"></el-badge></div>
              <div class="rank-item">asdasd<el-badge :value="12" class="item"></el-badge></div>
              <div class="rank-item">asdasd<el-badge :value="12" class="item"></el-badge></div>
              <div class="rank-item">asdasd<el-badge :value="12" class="item"></el-badge></div>
              <div class="rank-item">asdasd<el-badge :value="12" class="item"></el-badge></div>
              <div class="rank-item">asdasd<el-badge :value="12" class="item"></el-badge></div>
              <div class="rank-item">asdasd<el-badge :value="12" class="item"></el-badge></div>
            </div>
          </el-card>
        </el-col>
        <el-col :span='6'>
          <el-card class="rank-card">
            <div slot="header" class="clearfix">
              <span>Track top</span>
            </div>
            <div class="rank-list">
              <div class="rank-item">asdasd<el-badge :value="12" class="item"></el-badge></div>
              <div class="rank-item">asdasd<el-badge :value="12" class="item"></el-badge></div>
              <div class="rank-item">asdasd<el-badge :value="12" class="item"></el-badge></div>
              <div class="rank-item">asdasd<el-badge :value="12" class="item"></el-badge></div>
            </div>
          </el-card>
        </el-col>
      </el-row>
    </el-card>
  </div>
</template>

<script>
  export default {
    name: 'rank',
    data () {
      return {
        advisoryTop: 10023
      }
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
    .rank-card {
      margin: 0 8px;
      .rank-list{
        .rank-item{
          border-bottom: 1px solid #E9E9E9;
          padding: 10px 0;
          color: #5E5E5E;
          font-size: 14px;
          .el-badge{
            float: right
          }
        }
      }
    }
  }
</style>
