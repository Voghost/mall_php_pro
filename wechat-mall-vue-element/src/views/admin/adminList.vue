<template>
  <div class="app-container">
    <el-form :inline="true" class="demo-form-inline">
      <el-form-item>
        <el-button type="primary" @click="newAdmin">新增管理员</el-button>
      </el-form-item>
    </el-form>
    <el-table :data="tableData" stripe border style="width: 100%">
      <el-table-column type="index" label="序号" width="51"/>
      <el-table-column prop="user_id" label="管理员id" width="51"></el-table-column>
      <el-table-column prop="user_name" label="管理员名字"></el-table-column>
      <el-table-column label="管理员权限">
         <template slot-scope="scope">
           <span v-for="(item,index) in scope.row.role" :key="index">
             {{item + '  '}}
           </span>
         </template>
      </el-table-column>
      <el-table-column label="操作">
        <template slot-scope="scope">
          <el-button type="primary" @click="alertRoles(scope.row)">
            权限管理
          </el-button>
        </template>
      </el-table-column>
    </el-table>
    <el-dialog title="添加管理员" :visible.sync="addAdmin">
      <el-form :inline="true" :label-position="'top'" class="demo-form-inline">
        <el-form-item label="管理员名字">
          <el-input v-model="admin.username" placeholder="请输入管理员名称" required style="width: 400px"></el-input>
        </el-form-item>
        <br/>
        <el-form-item label="头像">
          <el-upload
            class="avatar-uploader"
            :action="baseUpdateUrl"
            :show-file-list="false"
            :on-success="handleMainSuccess"
            :before-upload="beforeMainUpload"
            style="border: 1px black dotted; height: 200px; width: 200px"
          >
            <img v-if="admin.avatar" :src="admin.avatar" class="avatar" style="width: 100%; height: auto">
            <i v-else class="el-icon-plus avatar-uploader-icon"></i>
          </el-upload>
        </el-form-item>
        <br/>
        <el-form-item label="输入密码">
          <el-input v-model="admin.password" placeholder="请输入密码" required style="width: 400px"></el-input>
        </el-form-item>
        <el-form-item label="确认密码">
          <el-input v-model="admin.repassword" placeholder="请再次输入密码" required style="width: 400px"></el-input>
        </el-form-item>
        <br/>
        <el-form-item>
          <el-button type="primary" @click="submitCat">提交</el-button>
        </el-form-item>
      </el-form>
    </el-dialog>
    <el-dialog title="权限管理" :visible.sync="changeRoles">
      <el-checkbox-group v-model="admin.role">
        <el-checkbox-button v-for="item in rolelist" :label="item" :key="item" @change="checked=>checkRow(item,checked,admin.user_id)">{{item}}</el-checkbox-button>
      </el-checkbox-group>
    </el-dialog>
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
import adminApi from '@/api/admin'

export default {
  data() {
    return {
      searchObj: {},
      tableData: [],
      rolelist: [],
      current: 1,
      total: 0,
      limit: 10,
      baseUpdateUrl: 'https://api-wechat-mall.ghovos.com/upload/file',
      addAdmin: false,
      changeRoles: false,
      admin: {
        user_id: null,
        username: null,
        password: null,
        repassword: null,
        avatar: null,
        roles: null
      }
    }
  },
  // 在渲染前运行
  created() {
    this.getList()
    this.getRole()
  },

  // 各种函数
  methods: {
    // 分页查询
    getList(page = 1) {
      this.current = page
      adminApi.pageSearchForUsers(this.searchObj, this.current, this.limit)
        .then(response => {
          console.log(response)
          this.tableData = response.data.content
          this.total = response.data.total
        })
        .catch(error => {
          console.log(error)
        })
    },
    getRole() {
      adminApi.getRole()
        .then(response => {
          console.log(response)
          this.rolelist = response.data
        })
        .catch(error => {
          console.log(error)
        })
    },
    newAdmin() {
      this.addAdmin = true
      this.admin.username = this.level
      this.admin.password = this.pid
    },
    saveAdmin() {
      adminApi.saveAdmin(this.admin)
        .then(res => {
          this.getList()
          console.log(res)
        })
        .catch(err => {
          console.log(err)
        })
    },
    submitCat() {
      if (this.admin.password === this.admin.repassword) {
        this.saveAdmin()
        this.addAdmin = false
      } else {
        alert('两次密码输入不同')
      }
    },
    alertRoles(data) {
      this.changeRoles = true
      this.admin = data
    },
    checkRow(item, value, id) {
      // console.log(item)
      // console.log(value)
      // console.log(id)
      if (value === true) {
        adminApi.addRole(id, item)
      } else if (value === false) {
        adminApi.deleteRole(id, item)
      }
    },
    handleMainSuccess(res) {
      this.admin.avatar = res.data.url
      console.log(this.imageUrl)
    },
    beforeMainUpload(file) {
      const isLt2M = file.size / 1024 / 1024 < 10

      if (!isLt2M) {
        this.$message.error('上传图片大小不能超过 10MB!')
      }
      return isLt2M
    }
  }
}
</script>

<style scoped>

</style>
