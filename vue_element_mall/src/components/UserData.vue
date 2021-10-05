<template>
  <div style="width: auto;height: 500px;position:relative">
    <div>
      <el-col :span="4" style="height: 200px;width: 200px;">
        <el-col style="padding: 20px 100px 10px;width: 400px;float: left">
          <el-tag class="text">用户名字:</el-tag>
          <el-tag class="text">{{ this.userdata.user_name }}</el-tag>
        </el-col>
        <div class="demo-basic--circle" style="float: left;padding: 40px">
          <div class="block">
            <el-avatar
                :size="250" icon="el-icon-user-solid"
                :src="userdata.user_avatar"
                style="display: block"></el-avatar>
          </div>
        </div>
      </el-col>

      <el-descriptions :column="1" border class="right_box">
        <el-descriptions-item label="用户性别">
          <el-tag class="text">{{ this.userdata.user_sex }}</el-tag>
<!--          <template>-->
<!--            <el-radio v-model="userdata.user_sex" label="男">男</el-radio>-->
<!--            <el-radio v-model="userdata.user_sex" label="女">女</el-radio>-->
<!--          </template>-->
        </el-descriptions-item>
        <el-descriptions-item label="用户年龄">
          <el-tag class="text">{{ this.userdata.user_age }}</el-tag>
<!--          <el-input v-model="userdata.user_age" placeholder="请输入年龄"></el-input>-->
        </el-descriptions-item>
        <el-descriptions-item label="用户邮箱">
          <el-tag class="text">{{ this.userdata.user_email }}</el-tag>
<!--          <el-input v-model="userdata.user_email" placeholder="请输入邮箱"></el-input>-->
        </el-descriptions-item>
        <el-descriptions-item label="用户电话">
          <el-tag class="text">{{ this.userdata.user_phone }}</el-tag>
<!--          <el-input v-model="userdata.user_phone" placeholder="请输入电话"></el-input>-->
        </el-descriptions-item>
        <!--        <el-descriptions-item label="快递地址">-->
        <!--          <el-tag class="text">{{ this.userdata.user_address_default }}</el-tag>-->
        <!--        </el-descriptions-item>-->
      </el-descriptions>
    </div>
    <el-link href="/AboutMe?selectedTag=4" class="el-button"
             style="font-size: 14px ;line-height: 30px;position:absolute;right: 30px;bottom:30px">修改信息
    </el-link>
    <div>
    </div>
  </div>
</template>

<script>
import userApi from '@/api/user'

export default {
  name: "UserData",
  data() {
    return {
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
    AlertUser(){
      console.log(this.userdata)
      userApi.updateUser(this.userdata)
          .then(res => {
            console.log(res)
            this.$store.commit("SET_USER_INFO", res.data.message)
          })
          .catch(error => {
            console.log(error)
          })
    }
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
