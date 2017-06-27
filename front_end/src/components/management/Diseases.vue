<template>
  <div class="disease-management">
    <el-card class="box-card">
      <h2>Disease management</h2>
      <el-button type="primary" icon="plus" class="add-disease"></el-button>
      <el-tree
        :data="data2"
        :props="defaultProps"
        show-checkbox
        node-key="id"
        default-expand-all
        :expand-on-click-node="false"
        :render-content="renderContent">
      </el-tree>
    </el-card>
  </div>
</template>

<script>
  let id = 1000;

  export default {
    data() {
      return {
        data2: [{
          id: 1,
          label: '一级 1',
          children: [{
            id: 4,
            label: '二级 1-1',
            children: [{
              id: 9,
              label: '三级 1-1-1'
            }, {
              id: 10,
              label: '三级 1-1-2'
            }]
          }]
        }, {
          id: 2,
          label: '一级 2',
          children: [{
            id: 5,
            label: '二级 2-1'
          }, {
            id: 6,
            label: '二级 2-2'
          }]
        }, {
          id: 3,
          label: '一级 3',
          children: [{
            id: 7,
            label: '二级 3-1'
          }, {
            id: 8,
            label: '二级 3-2'
          }]
        }],
        defaultProps: {
          children: 'children',
          label: 'label'
        }
      }
    },

    methods: {
      append(store, data) {
        store.append({ id: id++, label: 'testtest', children: [] }, data);
      },

      remove(store, data) {
//        store.remove(data);
        console.log(store, data)
      },

      renderContent(h, { node, data, store }) {
        return (
          <span>
            <span>
              <span>{node.label}</span>
            </span>
            <span style="float: right; margin-right: 20px">
              <el-button size="mini" on-click={ () => this.append(store, data) }>Append</el-button>
              <el-button size="mini" on-click={ () => this.remove(store, data) }>Delete</el-button>
            </span>
          </span>);
      }
    }
  };
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
  .box-card {
    margin: 15px;
    min-height: 85vh;
    h2 {
      margin-bottom: 5px;
    }
    .add-disease {
      margin-bottom: 15px;
    }
  }
</style>
