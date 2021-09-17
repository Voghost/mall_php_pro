<template>
  <div>
    <el-form ref="form"
             :model="form"
             label-width="80px"
             style="width: 500px;padding: 20px;float: left"
             :rules="rules"
             label-position="top">
      <el-form-item label="用户名字" required>
        <el-input v-model="form.name"></el-input>
      </el-form-item>
      <el-form-item label="用户性别">
        <el-radio v-model="form.sex" label="1">男</el-radio>
        <el-radio v-model="form.sex" label="2">女</el-radio>
        <el-radio v-model="form.sex" label="3">隐藏</el-radio>
      </el-form-item>
      <el-form-item label="用户年龄">
        <el-input-number v-model="form.age"></el-input-number>
      </el-form-item>
      <el-form-item label="用户邮箱" prop="userEmail">
        <el-input v-model="form.userEmail"></el-input>
      </el-form-item>
      <el-form-item label="用户电话" prop="userPhone">
        <el-input v-model="form.userPhone"></el-input>
      </el-form-item>
      <el-form-item>
        <el-button type="primary" @click="Onsubmit('form')">修改完成</el-button>
        <el-button @click="Resetform('form')">取消</el-button>
      </el-form-item>
    </el-form>
    <div style="float: right;margin: 100px"><!--头像上传-->
      头像上传:
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
  name: "Usersetting",
  components: {ImageUpload},
  data() {
      const  checkPhone = (rule, value, callback) => {
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
      form: {
        name: '',
        sex: '3',
        age: '18',
        userEmail: '请填写邮箱地址',
        userPhone: '请填写可使用的手机号码',
      },
      rules: {
        userEmail: [
          {validator: checkEmail, trigger: 'blur'}
        ],
        userPhone: [
          {validator: checkPhone, trigger: 'blur'}
        ],
      },
      methods: {
        Onsubmit(form) {
          let vm = this;
          this.$refs[form].validate((valid) => {
            if (valid) {
              vm.$refs.upload.submit();
            } else return false;
          });
        },
        Resetform(form) {
          this.$refs[form].resetFields();
          this.form.imageUrl = '';
        },
      }
    }
  }
}
</script>