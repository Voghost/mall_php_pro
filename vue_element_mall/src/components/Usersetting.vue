<template>
  <div>
    <el-form ref="form"
             :model="form"
             label-width="80px"
             style="width: 500px;padding: 20px;float: left"
             :rules="rules"
             label-position="top">
      <el-form-item label="用户性别">
        <el-radio v-model="form.user_sex" label="男">男</el-radio>
        <el-radio v-model="form.user_sex" label="女">女</el-radio>
        <el-radio v-model="form.user_sex" label="隐藏">隐藏</el-radio>
      </el-form-item>
      <el-form-item label="用户年龄">
        <el-input-number v-model="form.user_age"></el-input-number>
      </el-form-item>
      <el-form-item label="用户邮箱" prop="userEmail">
        <el-input v-model="form.user_email"></el-input>
      </el-form-item>
      <el-form-item label="用户电话" prop="userPhone">
        <el-input v-model="form.user_phone"></el-input>
      </el-form-item>
      <el-form-item>
        <el-button type="primary" @click="open()">修改完成</el-button>
        <el-button>取消</el-button>
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
    this.form = this.userdata
  },
  name: "UserSetting",
  components: {ImageUpload},
  data() {
    const checkPhone = (rule, value, callback) => {
      const phoneReg = /^1[0-9]{10}$/
      setTimeout(() => {
        if (phoneReg.test(value)) {
          callback()
        } else {
          callback(new Error('电话号码不正确'))
          console.log(value)
        }
      }, 100)
    }
    const checkEmail = (rule, value, callback) => {
      const mailReg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((.[a-zA-Z0-9_-]{2,3}){1,2})$/
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
      userdata: [],
      rules: {
        userEmail: [
          {validator: checkEmail, trigger: 'blur'}
        ],
        userPhone: [
          {validator: checkPhone, trigger: 'blur'}
        ],
      },
      form: [],
    }
  },
  methods: {
    open() {
      this.$confirm('是否确认修改?', '', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      }).then(() => {
        this.$message({
          type: 'success',
          message: '删除成功!'
        });
      }).catch(() => {
        this.$message({
          type: 'info',
          message: '已取消删除'
        });
      });
    }
  }

}
</script>
