<template>
  <div>
    <el-form ref="userdata"
             :model="userdata"
             label-width="80px"
             style="width: 500px;padding: 20px;float: left"
             :rules="rules"
             label-position="top">
      <el-form-item label="用户名字" required>
        <el-input v-model="userdata.user_name"></el-input>
      </el-form-item>
      <el-form-item label="用户性别">
        <el-radio v-model="userdata.user_sex" label="1">男</el-radio>
        <el-radio v-model="userdata.user_sex" label="2">女</el-radio>
        <el-radio v-model="userdata.user_sex" label="3">隐藏</el-radio>
      </el-form-item>
      <el-form-item label="用户年龄">
        <el-input-number v-model="userdata.user_age"></el-input-number>
      </el-form-item>
      <el-form-item label="用户邮箱" prop="userEmail">
        <el-input v-model="userdata.user_email"></el-input>
      </el-form-item>
      <el-form-item label="用户电话" prop="userPhone">
        <el-input v-model="userdata.user_phone"></el-input>
      </el-form-item>
      <el-form-item>
        <el-button type="primary" >修改完成</el-button>
        <el-button >取消</el-button>
      </el-form-item>
    </el-form>
    <div style="float: right;margin: 100px"><!--头像上传-->
      <el-tag>头像上传：</el-tag>
      <ImageUpload></ImageUpload>
    </div>
  </div>
</template>
<style>
input[type="file"] {
  display: none;
}

</style>
<script>

import ImageUpload from "@/components/ImageUpload";

export default {
  created() {
    this.userdata = this.$store.state.userInfo
    console.log(this.userdata)
  },
  name: "Usersetting",
  components: {ImageUpload},
  data() {
    const checkPhone = (rule, value, callback) => {
      const phoneReg = /^1[3-8][0-9]{9}$/
      if (!value) {
        return callback(new Error('电话号码不能为空'))
      }
      setTimeout(() => {
        if (!Number.isInteger(+value)) {
          callback(new Error('请输入数字值'))
        } else {
          if (phoneReg.test(value)) {
            callback()
          } else {
            callback(new Error('电话号码格式不正确'))
          }
        }
      }, 100)
    }
    const checkEmail = (rule, value, callback) => {
      const mailReg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/
      if (!value) {
        return callback(new Error('邮箱不能为空'))
      }
      setTimeout(() => {
        if (mailReg.test(value)) {
          callback()
        } else {
          callback(new Error('请输入正确的邮箱格式'))
        }
      }, 100)
    }
    return {
      dialogTableVisible: false,
      baseUpdateUrl: 'http://mall.php.test/upload/file',
      userdata:[],
      rules: {
        userEmail: [
          {validator: checkEmail, trigger: 'blur'}
        ],
        userPhone: [
          {validator: checkPhone, trigger: 'blur'}
        ],
      },

    }
  },
}
</script>
