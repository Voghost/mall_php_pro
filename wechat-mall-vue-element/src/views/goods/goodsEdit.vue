<template>
  <div class="app-container">
    <el-form :inline="true" :label-position="'top'" class="demo-form-inline">
      <el-row>
        <el-col :span="6">
          <el-form-item label="商品分类">
            <el-cascader :props="props" placeholder="请选择分类" v-model="catArr" style="width: 300px"></el-cascader>
          </el-form-item>
        </el-col>
        <el-col :span="10">
          <el-form-item label="商品名字">
            <el-input v-model="goods.goodsName" placeholder="请输入商品名字 *" required style="width: 600px"></el-input>
          </el-form-item>
        </el-col>
      </el-row>
      <el-row>
        <el-col :span="6">
          <el-form-item label="商品价格">
            <el-input-number
              v-model="goods.goodsPrice"
              :precision="2"
              :step="0.1"
              :max="999999"
              :min="0"
            ></el-input-number>
          </el-form-item>
          <br/>
          <el-form-item label="商品库存">
            <el-input-number v-model="goods.goodsNumber" :step="1" :min="0"></el-input-number>
          </el-form-item>
          <br/>
          <el-form-item label="商品重量(kg)">
            <el-input-number
              v-model="goods.goodsWeight"
              :precision="2"
              :step="0.1"
              :max="999999"
              :min="0"
            ></el-input-number>
          </el-form-item>
        </el-col>
        <el-col :span="5">
          <el-form-item label="商品主图">
            <el-upload
              class="avatar-uploader"
              :action="baseUpdateUrl"
              :show-file-list="false"
              :on-success="handleMainSuccess"
              :before-upload="beforeMainUpload"
              style="border: 1px black dotted; border-radius: 10px;"
            >
              <img v-if="goods.goodsBigLogo" :src="goods.goodsBigLogo" class="avatar">
              <i v-else class="el-icon-plus avatar-uploader-icon"></i>
            </el-upload>
          </el-form-item>
        </el-col>
        <el-col :span="12">
          <el-form-item label="商品副图">
            <el-upload
              class="upload-demo"
              :action="baseUpdateUrl"
              :file-list="fileList"
              :on-preview="handlePreview"
              :before-remove="handleRemove"
              :on-success="handleSecondSuccess"
              list-type="picture-card"
            >
              <el-button size="small" type="primary">点击上传</el-button>
              <div slot="tip" class="el-upload__tip">只能上传jpg/png文件，且不超过500kb</div>
            </el-upload>
          </el-form-item>
        </el-col>
      </el-row>
      <Editor v-model="goods.goodsIntroduce" style="width: 90%"/>
      <el-form-item>
        <el-button type="primary" @click="onSubmit">提交</el-button>
      </el-form-item>
    </el-form>
    <el-dialog
      title="图片详情"
      :visible.sync="dialogVisible"
      width="40%"
    >
      <img width="100%" :src="dialogImageUrl"/>
    </el-dialog>
  </div>
</template>

<script>
import goodsApi from '@/api/goods'
import Editor from '@/components/Editor'

export default {
  components: { Editor },
  data() {
    return {
      isEdit: false,
      fileList: [],
      baseUpdateUrl: 'http://mall.php.test/upload/file',
      catArr: [],
      imageUrl: '',
      goods: {
        goodsBigLogo: '',
        goodsPicOne: '',
        goodsPicTwo: '',
        goodsPicThree: '',
        goodsIntroduce: ''
      },
      dialogImageUrl: '',
      dialogVisible: false,
      props: {
        lazy: true,
        lazyLoad(node, resolve) {
          const { level } = node
          let value = node.value
          if (level === 0) {
            value = 0
          }
          goodsApi.getCategory(level + 1, value).then(res => {
            // console.log(node)
            let i = 0
            const nodes = Array.from({ length: res.data.length })
              .map(item => ({
                value: res.data[i].cat_id,
                label: res.data[i++].cat_name,
                leaf: level >= 2
              }))
            // 通过调用resolve将子节点数据返回，通知组件数据加载完成
            resolve(nodes)
          })
        }
      }
    }
  },
  created() {
    // 如果是跳转来的，则接受初始化参数
    if (this.$route.query.goods) {
      this.isEdit = true
      console.log(this.$route.query)
      this.goods.goodsId = this.$route.query.goods.goods_id
      this.goods.goodsName = this.$route.query.goods.goods_name
      this.goods.goodsIntroduce = this.$route.query.goods.goods_introduce
      this.goods.goodsPrice = this.$route.query.goods.goods_price
      this.goods.goodsNumber = this.$route.query.goods.goods_number
      this.goods.goodsWeight = this.$route.query.goods.goods_weight
      this.goods.goodsCatThreeId = this.$route.query.goods.goods_cat_three_id
      this.goods.goodsBigLogo = this.$route.query.goods.goods_big_logo
      this.goods.goodsPics = this.$route.query.goods.pics
      this.catArr = [
        this.$route.query.goods.goods_cat_one_id,
        this.$route.query.goods.goods_cat_two_id,
        this.$route.query.goods.goods_cat_three_id
      ]
      for (let i = 0; i < this.goods.goodsPics.length; i++) {
        const item = this.goods.goodsPics[i]
        this.fileList.push({ name: item.name, url: item.url, id: item.id })
      }
    }
  },
  methods: {
    onSubmit() {
      console.log(this.catArr)
      this.goods.goodsCatThreeId = this.catArr[2]
      goodsApi.saveOrUpdateGoods(this.goods)
        .then(res => {
          console.log(res)
          this.$router.push({
            path: '/goodsManager/goodsList'
          })
        })
        .catch(error => {
          console.log(error)
        })
    },
    handleMainSuccess(res, file) {
      this.goods.goodsBigLogo = res.data.url
      console.log(this.imageUrl)
    },
    beforeMainUpload(file) {
      const isLt2M = file.size / 1024 / 1024 < 10

      if (!isLt2M) {
        this.$message.error('上传图片大小不能超过 10MB!')
      }
      return isLt2M
    },
    handleRemove(file, fileList) {
      console.log(file)
      // 如果是编辑
      if (this.isEdit) {
        return this.$confirm('此操作将删除商品置信息, 是否继续?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          goodsApi.deletePic(file.id)
            .then(response => {
              console.log(response)
              this.$message({
                type: 'success',
                message: '删除成功!'
              })
            })
        }).catch(() => {
          this.$message({
            type: 'info',
            message: '已取消删除'
          })
          this.reject(new Error('取消')).catch(err => {
            console.log(err)
          })
        })
        // TODO 从服务器删除list
      }
      this.removeByValue(this.fileList, 'url', file.url)
    },
    handlePreview(file) {
      this.dialogVisible = true
      console.log(file)
      this.dialogImageUrl = file.url
    },
    handleSecondSuccess(file) {
      this.fileList.push({ 'name': file.data.name, 'url': file.data.url, id: -1 })
    },
    // 根据属性值删除函数
    removeByValue(arr, attr, value) {
      let index = 0
      for (const i in arr) {
        if (arr[i][attr] === value) {
          index = i
          break
        }
      }
      arr.splice(index, 1)
    }
  }
}

</script>

<style scoped>
.avatar-uploader .el-upload {
  border: 1px dashed #413e3e;
  border-radius: 6px;
  cursor: pointer;
  position: relative;
  overflow: hidden;
}

.avatar-uploader .el-upload:hover {
  border-color: #031126;
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
