<template>
  <div class="app-container">
    <el-form :inline="true" class="demo-form-inline">
      <el-form-item label="用户名字">
        <el-input v-model="searchObj.user_id" placeholder="用户id"/>
      </el-form-item>
      <el-form-item>
        <el-button type="primary" @click="getList()">查询</el-button>
      </el-form-item>
    </el-form>
    <el-table :data="tableData" stripe border style="width: 100%">
      <el-table-column type="index" label="序号" width="51"/>
      <el-table-column prop="user_id" label="用户id" width="51"></el-table-column>
      <el-table-column prop="user_create_time" label="用户创建时间" width="250"></el-table-column>
      <el-table-column prop="user_update_time" label="用户更新时间时间" width="250"></el-table-column>
      <el-table-column prop="user_last_login_time" label="用户最后登陆时间" width="250"></el-table-column>
      <el-table-column label="用户状态" width="120">
        <template slot-scope="scope">
          <div v-if="scope.row.user_is_active===1">
            <i class="el-icon-upload2"/>正常
          </div>
          <div v-if="scope.row.user_is_active===0">
            <i class="el-icon-download"/>封禁
          </div>
        </template>
      </el-table-column>
      <el-table-column label="操作">
        <template slot-scope="scope">
          <el-button
            type="danger"
            size="mini"
            icon="el-icon-download"
            v-if="scope.row.user_is_active===1"
            @click="upOrDownUsers(scope.row.user_id, 0)"
          >
            封禁
          </el-button>
          <el-button
            type="primary"
            size="mini"
            icon="el-icon-upload2"
            v-if="scope.row.user_is_active===0"
            @click="upOrDownUsers(scope.row.user_id, 1)"
          >
            解禁
          </el-button>
        </template>
      </el-table-column>
    </el-table>
    <!--目录-->
    <div class="block">
      <!--      <span class="demonstration">直接前往</span>-->
      <el-pagination
        @size-change="limit"
        @current-change="getList"
        :page-size="limit"
        layout="prev, pager, next, jumper"
        :total="total"
        style="padding: 30px 0; text-align: center"
      >
      </el-pagination>
    </div>
  </div>
</template>

<script>
import usersApi from '@/api/users'

export default {
  data() {
    return {
      searchObj: {},
      tableData: [],
      current: 1,
      total: 0,
      limit: 10
    }
  },
  // 在渲染前运行
  created() {
    this.getList()
  },

  // 各种函数
  methods: {
    // 分页查询
    getList(page = 1) {
      this.current = page
      usersApi.pageSearchForUsers(this.searchObj, this.current, this.limit)
        .then(response => {
          this.tableData = response.data.content
          this.total = response.data.total
        })
        .catch(error => {
          console.log(error)
        })
    },
    upOrDownUsers(id, state) {
      usersApi.updateState(id, state)
        .then(response => {
          console.log(response)
          this.getList(this.current)
        })
        .catch(error => {
          console.log(error)
        })
    }
  }
}
</script>

<style scoped>

</style>
