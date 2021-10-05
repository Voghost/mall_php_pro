<template>
  <el-dialog title="评论" :visible.sync="handle" width="500px"  center>
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
<!--        <el-button type="primary" @click="childOperation('confirm')">提交</el-button>-->
        <el-button @click="childOperation('cancel')">取消</el-button>
      </el-form-item>
    </el-form>
  </el-dialog>



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
      goods_id : 0,
      commentOnsubmit : {},
      handle : this.hand


    }
  },
  methods : {
    childOperation(value) {
      this.$emit('child-operation',value);
    },
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
      console.log(this.gid)

      let temp = [];
      for(let index in this.fileList){
        temp.push({name: this.fileList[index].name, url: this.fileList[index].url})
      }
      this.commentOnsubmit.star = this.form.star
      this.commentOnsubmit.pics = temp;
      this.commentOnsubmit.goods_id = this.gid;
      this.commentOnsubmit.content = this.form.desc;
      this.commentOnsubmit.order_id = this.orderid;
      console.log(this.commentOnsubmit)
      this.$api.user.addComment(this.commentOnsubmit)
      this.childOperation('confirm')
      // console.log(this.commentOnsubmit.goods_id)


    },



  },
  watch: {
    hand(val) {
      this.handle = val;//②监听外部对props属性result的变更，并同步到组件内的data属性myResult中
    },
    handle(val){
      this.$emit("on-result-change",val);//③组件内对myResult变更后向外部发送事件通知
    }
  },
  props :[
      'gid' ,
      'orderid',
      'hand'
  ]

}
</script>

<style scoped>

</style>
