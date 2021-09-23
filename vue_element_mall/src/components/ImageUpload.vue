<template>
  <el-upload
      class="avatar-uploader"
      :action="baseUpdateUrl"
      :headers="myHeaders"
      :show-file-list="false"
      :on-success="handleAvatarSuccess"
      :before-upload="beforeAvatarUpload"
  >
    <img v-if="baseUpdateUrl" :src="imageUrl" class="avatar"/>
    <i v-else class="el-icon-plus avatar-uploader-icon"></i>
  </el-upload>
</template>

<script>
export default {
  data() {
    return {
      imageUrl: "https://cube.elemecdn.com/3/7c/3ea6beec64369c2642b92c6726f1epng.png",
      myHeaders: {Authorization: localStorage.getItem('_UTK')}, //获取Token
      baseUpdateUrl: 'http://mall.php.test/upload/file',
    }
  },
  methods: {
    handleAvatarSuccess(res, file) {
      this.imageUrl = URL.createObjectURL(file.raw);
    },
    beforeAvatarUpload(file) {
      const isJPG = file.type === "image/png" || "image/jpg" || "image/jpeg";
      const isLt2M = file.size / 1024 / 1024 < 2;
      if (!isJPG) {
        this.$message.error("上传头像图片只能是 JPG/PNG/JPEG 格式!");
      }
      if (!isLt2M) {
        this.$message.error("上传头像图片大小不能超过 2MB!");
      }
      return isJPG && isLt2M;
    }
  },
  props: ["imgSrc"],
  created() {
    if (this.imgSrc != null && this.imgSrc !== '') {
      this.imageUrl = this.imgSrc;
    }
  }
}
</script>

<style scoped>

.avatar-uploader-icon {
  font-size: 28px;
  color: white;
  width: 100px;
  height: 100px;
  line-height: 100px;
  text-align: center;
  border: 1px dashed #fff;
  margin-top: -20px;
}

.avatar {
  width: 250px;
  height: 250px;
  display: block;
}
</style>
