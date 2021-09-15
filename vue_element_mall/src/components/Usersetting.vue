<template>
  <el-form ref="form" :model="form" label-width="80px" style="width: 500px;padding: 20px" :rules="rules">
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
    <el-form-item label="上传头像" ref="uploadImage" prop="imageurl">
      <el-upload
          class="avatar-uploader"
          ref="upload"
          :action="baseUpdateUrl"
          :show-file-list="false"
          :on-change="handleSuccess"
          :before-upload="beforeUpload"
          :data="form">
        <img v-if="form.imageUrl" :src="form.imageUrl" class="avatar">
        <i v-else class="el-icon-plus avatar-uploader-icon"></i>
      </el-upload>
    </el-form-item>
    <el-form-item label="邮递地址">
    <AddressChoose></AddressChoose>
    </el-form-item>
    <el-form-item>
      <el-button type="primary" @click="onSubmit">立即创建</el-button>
      <el-button @click="resetForm('form')">取消</el-button>
    </el-form-item>
  </el-form>
</template>
<style>
input[type="file"]{
  display: none;
}

.avatar-uploader .el-upload {
  border: 1px dashed #d9d9d9;
  border-radius: 6px;
  cursor: pointer;
  position: relative;
  overflow: hidden;
}

.avatar-uploader .el-upload:hover {
  border-color: #409EFF;
}

.avatar-uploader-icon {
  font-size: 28px;
  color: #8c939d;
  width: 178px;
  height: 178px;
  line-height: 178px;
  text-align: center;
}

.avatar {
  width: 178px;
  height: 178px;
  display: block;
}
</style>
<script>
import AddressChoose from "@/components/AddressChoose";
export default {
  name: "Usersetting",
  components: {AddressChoose},
  data() {
    var checkPhone = (rule, value, callback) => {
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
    var checkEmail = (rule, value, callback) => {
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
      baseUpdateUrl:'http://mall.php.test/upload/file',
      form: {
        name: '',
        sex: '3',
        age: '18',
        userEmail: '请填写邮箱地址',
        userPhone: '请填写可使用的手机号码',
        imageUrl: ''
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
        onSubmit(form) {
          let vm=this;
          this.$refs[form].validate((valid)=>{
            if(valid){
              vm.$refs.upload.submit();
            }else return false;
          });
        },
        resetForm(form){
          this.$refs[form].resetFields();
          this.form.imageUrl='';
        },
        // eslint-disable-next-line no-unused-vars
        handleSuccess(res, file='') {
          this.imageUrl = res.data.imageUrl;
          console.log(this.imageUrl);
        },
        beforeUpload(file) {
          const isJPG = file.type === 'image/jpeg' || file.type === 'image/png';
          const isLt2M = file.size / 1024 / 1024 < 2;

          if (!isJPG) {
            this.$message.error('上传头像图片只能是 JPEG/PNG 格式!');
          }
          if (!isLt2M) {
            this.$message.error('上传头像图片大小不能超过 2MB!');
          }
          return isJPG && isLt2M;
        }
      }
    };
  }
}

</script>