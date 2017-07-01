<template>
  <div class="disease-management">
    <el-card class="box-card">
      <h2>Disease management</h2>
      <el-tree
        ref="treeParent"
        :data="diseases"
        :props="defaultProps"
        :show-checkbox="false"
        node-key="id"
        default-expand-all
        :expand-on-click-node="false"
        :render-content="renderContent">
      </el-tree>
    </el-card>
  </div>
</template>

<script>
  import axios from '../../config/axiosConfig'
  import qs from 'qs'

  export default {
    data() {
      return {
        diseases: [{id: 1, name: 'root', children: []}],
        defaultProps: {
          children: 'children',
          label: 'name'
        }
      }
    },

    methods: {
      appendDisease(store, data) {
        let self = this;
        this.$prompt('Please enter a disease name', 'Tips', {
          showCancelButton: false,
          confirmButtonText: 'Create',
          inputPlaceholder: 'new disease name'
        })
          .then(({value}) => {
            axios.get(`/management/diseases/${data.id}/${value}`)
              .then(res => {
                store.append({id: res.disease.id, name: res.disease.name, children: []}, data);
              })
          });
      },
      removeDsiease(store, data) {
        axios.delete(`/management/diseases/${data.id}`)
          .then(res => {
            store.remove(data);
          })
      },
      editDsiease(store, data){
        this.$prompt('Please enter a disease name', 'Tips', {
          showCancelButton: false,
          confirmButtonText: 'Create',
          inputPlaceholder: 'new disease name'
        })
          .then(({value}) => {
            axios.patch(`/management/diseases/${data.id}`, qs.stringify({name: value}))
            .then(res=>{
              data.name = res.disease.name;
            })
          });
      },
      renderContent(h, {node, data, store}) {
        return (
          <span>
          <span>
          <span>{node.label}</span>
        </span>
        <span style="float: right; margin-right: 20px">
          <el-button size="mini" type="primary" icon="plus" on-click={ () => this.appendDisease(store, data) }></el-button>
        <el-button size="mini" icon="edit" on-click={ () => this.editDsiease(store, data) }></el-button>
        <el-button size="mini" type="danger" icon="delete" on-click={ () => this.removeDsiease(store, data) }></el-button>
        </span>
        </span>);
      }
    },
    mounted(){
      let self = this;
      axios.get('/management/diseases')
        .then(res => {
          for (let disease in res.diseases) {
            self.diseases[0].children.push(res.diseases[disease])
          }
        })
    }
  };
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
  .box-card {
    margin: 15px;
    min-height: 85vh;
    h2 {
      margin-bottom: 20px;
    }
    .el-tree{
      border: none;
    }
  }
</style>
