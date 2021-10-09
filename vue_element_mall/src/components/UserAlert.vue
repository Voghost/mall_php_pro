<template>
  <div style="width: auto;height: 500px;position:relative">
    <el-form ref="form" :inline="true" :model="this.userdata" label-width="80px">
      <el-form-item label="名称">
        {{ this.userdata.user_name }}
      </el-form-item>
      <el-form-item label="性别">
        <template>
          <el-radio v-model="userdata.user_sex" label="男">男</el-radio>
          <el-radio v-model="userdata.user_sex" label="女">女</el-radio>
        </template>
      </el-form-item>
      <el-form-item label="年龄">
        <el-input v-model="userdata.user_age" style="width: 50px"></el-input>
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
          <img v-if="userdata.user_avatar" :src="userdata.user_avatar" class="avatar" style="width: 100%; height: auto">
          <i v-else class="el-icon-plus avatar-uploader-icon"></i>
        </el-upload>
      </el-form-item>
      <br/>
      <el-form-item label="邮箱">
        <el-input v-model="userdata.user_email" style="width: 350px"></el-input>
      </el-form-item>
      <br/>
      <el-form-item label="电话">
        <el-input v-model="userdata.user_phone" style="width: 350px"></el-input>
      </el-form-item>
      <br/>
      <el-form-item>
        <el-button type="primary" @click="AlertUser">修改</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
import userApi from '@/api/user'

export default {
  name: "UserData",
  data() {
    return {
      baseUpdateUrl: 'https://api-wechat-mall.ghovos.com/upload/file',
      userdata: {
        // user_email: '123456789@qq.com',
        // user_phone: '123456789',
        // user_name: '王小虎',
        // user_sex: '男',
        // user_age: '18'
      },
      circleUrl: "https://cube.elemecdn.com/3/7c/3ea6beec64369c2642b92c6726f1epng.png",
    }
  },
  created() {
    this.userdata = this.$store.state.userInfo
    console.log(this.userdata)
  },
  methods: {
    AlertUser() {
      console.log(this.userdata)
      userApi.updateUser(this.userdata)
          .then(res => {
            console.log(res)
            this.$store.commit("SET_USER_INFO", res.data.message)
            this.$message.info("修改成功")
          })
          .catch(error => {
            console.log(error)
          })
    },
    handleMainSuccess(res) {
      this.userdata.user_avatar = res.data.url
      console.log(this.imageUrl)
    },
    beforeMainUpload(file) {
      const isLt2M = file.size / 1024 / 1024 < 10

      if (!isLt2M) {
        this.$message.error('上传图片大小不能超过 10MB!')
      }
      return isLt2M
    },
  }
}
</script>

<style scoped>
.right_box {
  width: 700px;
  float: right;
  height: 300px;
  margin-top: 70px;
}

.text {
  font-size: 14px;
}

</style>
