<template>
<div>
  <el-tabs v-model="tabsName" style="margin-left: 35px;margin-top: 20px;font-size: 20px">
    <el-tab-pane label="产品评论" name="first">
      <el-form label-width="100px" :model="form" ref="loginFormRef">
        <el-form-item label="产品评分:">
          <el-rate v-model="form.star" show-text></el-rate>
        </el-form-item>
        <el-form-item label="评价内容:">
          <el-input type="textarea" :rows="3" v-model="form.desc" :maxlength="150" placeholder="请输入内容"
                    show-word-limit></el-input>
        </el-form-item>
        <el-form-item label="上传照片:">
          <el-upload :action="baseUpdateUrl"
                     list-type="picture-card"
                     :file-list="fileList"
                     :on-success="handlePicSuccess"
                     :on-remove="handleRemove"
                     :on-preview="handlePictureCardPreview">
            <el-button size="small" type="primary">点击上传</el-button>
            <div slot="tip" class="el-upload__tip">只能上传3个jpg/png文件，且不超过10MB</div>
          </el-upload>
          <el-dialog :visible.sync="dialogVisible">
            <img width="100%" :src="dialogImageUrl" alt="">
          </el-dialog>

        </el-form-item>
        <el-form-item>
          <el-button type="primary" @click="onSubmit">提交</el-button>
          <el-button>取消</el-button>
        </el-form-item>
      </el-form>
    </el-tab-pane>

  </el-tabs>
</div>
</template>

<script>
export default {
  name: "GoodsComment",
  data() {
    return{
      tabsName: 'first', //标签页默认显示
      form: {
        desc: "",
        star: null,
      },
      baseUpdateUrl: 'http://mall.php.test/upload/file',
      fileList: [],
      dialogImageUrl: '',
      dialogVisible: false,
      order_id : 99,
      commentOnsubmit : {},
    }
  },
  methods : {
    //照片上传
    handleRemove(file, fileList) {
      console.log(file, fileList);
    },
    handlePictureCardPreview(file) {
      this.dialogImageUrl = file.url;
      this.dialogVisible = true;
    },
    handlePicSuccess(file) {
      this.fileList.push({'name': file.data.name , 'url': file.data.url , id: -1})
      console.log(this.fileList)
    },
    //评论提交
    onSubmit() {
      // console.log('submit')
      return this.$confirm('设置好的属性提交后将不能修改?', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      }).then(() => {
        this.commentOnsubmit.star = this.form.star
        this.commentOnsubmit.pics = this.fileList;
        this.commentOnsubmit.content = this.form.desc;
        this.commentOnsubmit.order_id = this.order_id;
        console.log(this.commentOnsubmit)
      }).catch(() => {
        this.$message({
          type: 'info',
          message: '已取消删除'
        })
        this.reject(new Error('取消')).catch(err => {
          console.log(err)
        })
      })
    },
  }
}
</script>

<style scoped>

</style>