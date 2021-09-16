<template>
  <el-form ref="form"
           :model="form"
           label-width="80px"
           style="width: 500px;padding: 20px" :rules="rules"
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
    <el-form-item label="上传头像">
      <el-upload
          class="avatar-uploader"
          list-type="picture"
          accept="image/png,image/gif,image/jpg,image/jpeg"
          :action="baseUpdateUrl"
          :show-file-list="false"
          :on-change="handleSuccess"
          :on-success="handleMainSuccess"
          :before-upload="beforeUpload"
          style="border-radius: 10px"
          :data="form">
        <img v-if="form.imageUrl" :src="form.imageUrl" class="avatar">
        <i v-else class="el-icon-plus avatar-uploader-icon"></i>
      </el-upload>
    </el-form-item>
    <el-form-item label="邮递地址" required>

      <el-col>
        <el-radio v-model="form.userAddress" label="1">快递地址1:12345649876z4c8xz45c6
          <el-button type="button" @click="dialogTableVisible = true">修改</el-button>
          <el-dialog title="收货地址修改" :visible.sync="dialogTableVisible">
            <AddressChoose></AddressChoose>
          </el-dialog>
        </el-radio>
        <el-radio v-model="form.userAddress" label="2">快递地址2:c41xx3z4c56xz1c32zxc56xz</el-radio>
      </el-col>
      <el-button type="text" @click="dialogTableVisible = true">快递地址:添加</el-button>
      <el-dialog title="收货地址修改" :visible.sync="dialogTableVisible">
        <AddressChoose></AddressChoose>
      </el-dialog>
    </el-form-item>
    <el-form-item>
      <el-button type="primary" @click="onSubmit">修改完成</el-button>
      <el-button @click="resetForm('form')">取消</el-button>
    </el-form-item>
  </el-form>
</template>
<style>
input[type="file"] {
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
      dialogTableVisible: false,
      baseUpdateUrl: 'http://mall.php.test/upload/file',
      form: {
        name: '',
        sex: '3',
        age: '18',
        userEmail: '请填写邮箱地址',
        userPhone: '请填写可使用的手机号码',
        imageUrl: '',
        userAddress: '1'
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
          let vm = this;
          this.$refs[form].validate((valid) => {
            if (valid) {
              vm.$refs.upload.submit();
            } else return false;
          });
        },
        resetForm(form) {
          this.$refs[form].resetFields();
          this.form.imageUrl = '';
        },
        handleSuccess(res, file) {
          this.imageUrl = URL.createObjectURL(file.raw);
          console.log(this.imageUrl);
        },
        beforeUpload(file) {
          const isJPG = file.type === 'image/png' || file.type === 'image/gif' || file.type === 'image/jpg' || file.type === 'image/jpeg'
          const isLt2M = file.size / 1024 / 1024 < 2;

          if (!isJPG) {
            this.$message.error('上传头像图片只能是 JPEG/PNG/JPG/GIF 格式!');
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