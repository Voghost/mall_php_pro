<template>
  <div>
    <el-button @click="editAll">批量编辑</el-button>
    <el-button @click="submit">保存修改</el-button>
    <el-button @click="addOne">增加</el-button>
    <el-button @click="delectAll">批量删除</el-button>
    <el-table :data="tabledatas" border @selection-change="handleSelectionChange">
      <el-table-column type="selection"></el-table-column>
      <el-table-column label="收件人名字" width="150px">
        <template slot-scope="scope">
                    <span v-if="scope.row.show">
                        <el-input size="mini" placeholder="请输入内容" v-model="scope.row.username"></el-input>
                    </span>
          <span v-else>{{ scope.row.username }}</span>
        </template>
      </el-table-column>
      <el-table-column label="收件地址">
        <template slot-scope="scope">
                    <span v-if="scope.row.show">
                        <el-input size="mini" placeholder="请输入内容" v-model="scope.row.userAddress"></el-input>
                    </span>
          <span v-else>{{ scope.row.userAddress }}</span>
        </template>
      </el-table-column>
      <el-table-column label="收件人电话" width="200px">
        <template slot-scope="scope">
                    <span v-if="scope.row.show">
                        <el-input size="mini" placeholder="请输入内容" v-model="scope.row.phone_number"></el-input>
                    </span>
          <span v-else>{{ scope.row.phone_number }}</span>
        </template>
      </el-table-column>
      <el-table-column label="操作">
        <template slot-scope="scope">
          <el-button @click="edit(scope.row,scope.$index)">{{ scope.row.show ? '保存' : "修改" }}</el-button>
          <el-button v-if="scope.row.default">默认地址</el-button><!--设置默认地址-->
          <el-button v-else @click="setDefaults(scope.row)">设为默认地址</el-button>
          <el-button @click="deleteOne(scope.$index)">删除</el-button>
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>
<script>
import Vue from 'vue'

export default {
  data() {
    return {
      tabledatas: [],
      multipleSelection: [],
    }
  },
  created() {
    this.tabledatas = [
      {username: '标题1', userAddress: 's111sssa',phone_number:'13621463292',default:true },
      {username: '标题2', userAddress: 'ss222ssa',phone_number:'13621463292',default:false},
      {username: '标题2', userAddress: 'ss222ssa',phone_number:'13621463292',default:false},
    ]
    this.tabledatas.map(i => {
      i.show = false
      return i
    })
  },
  methods: {
    edit(row, index) {
      row.show = !row.show
      Vue.set(this.tabledatas, index, row)
      // 修改后保存
    },
    editAll() {
      this.tabledatas.map((i, index) => {
        i.show = true
        Vue.set(this.tabledatas, index, i)
      })
    },
    submit() {
      this.tabledatas.map((i, index) => {
        i.show = false
        Vue.set(this.tabledatas, index, i)
      })
    },
    // 单个复制
    cope(val, index) {
      this.tabledatas.splice(index, 0, JSON.parse(JSON.stringify(val)))
    },
    setDefaults(index){
      this.tabledatas.map((i) => {
        i.default=false;
      })
      index.default=true;
    },
    // 单个删除
    deleteOne(index) {
      this.tabledatas.splice(index, 1)
    },
    //批量新增
    addOne() {
      let list = {
        title: "",
        text: "",
        phone_number:"",
      }
      this.tabledatas.push(list)
    },
    //批量删除
    delectAll() {
      for (let i = 0; i < this.tabledatas.length; i++) {
        const element = this.tabledatas[i];
        element.id = i
      }
      if (this.multipleSelection.length === 0) this.$message.error('请先至少选择一项')
      this.multipleSelection.forEach(element => {
        this.tabledatas.forEach((e, i) => {
          if (element.id === e.id) {
            this.tabledatas.splice(i, 1)
          }
        });
      });
    },
    //选
    handleSelectionChange(val) {
      this.multipleSelection = val;
    }
  },
}
</script>