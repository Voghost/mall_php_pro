<template>
  <div class="app-container">
    <el-form :inline="true" :label-position="'top'" class="demo-form-inline">
      <el-form-item label="商品分类">
        <el-cascader :props="props" placeholder="请选择分类" v-model="catArr" style="width: 300px"></el-cascader>
      </el-form-item>
      <br/>
      <el-form-item label="商品名字">
        <el-input v-model="goods.goodsName" placeholder="请输入商品名字 *" required style="width: 600px"></el-input>
      </el-form-item>
      <br/>
      <el-form-item label="商品价格">
        <el-input-number v-model="goods.goodsPrice" :precision="2" :step="0.1" :max="999999" :min="0"></el-input-number>
      </el-form-item>
      <el-form-item label="商品库存">
        <el-input-number v-model="goods.goodsNumber" :step="1" :min="0"></el-input-number>
      </el-form-item>
      <el-form-item label="商品重量(kg)">
        <el-input-number
          v-model="goods.goodsWeight"
          :precision="2"
          :step="0.1"
          :max="999999"
          :min="0"
        ></el-input-number>
      </el-form-item>
      <br/>
      <el-form-item label="商品主图">
        <el-upload
          class="avatar-uploader"
          action="https://api-wechat-mall.ghovos.com/upload/file"
          :show-file-list="false"
          :on-success="handleMainSuccess"
          :before-upload="beforeMainUpload"
        >
          <img v-if="goods.goodsBigLogo" :src="goods.goodsBigLogo" class="avatar">
          <i v-else class="el-icon-plus avatar-uploader-icon"></i>
        </el-upload>
      </el-form-item>
      <br/>
      <el-form-item label="商品副图">
        <el-upload
          style="display: inline-block"
          class="avatar-uploader"
          action="https://api-wechat-mall.ghovos.com/upload/file"
          :show-file-list="false"
          :on-success="handleFirstSuccess"
          :before-upload="beforeMainUpload"
        >
          <img v-if="goods.goodsPicOne" :src="goods.goodsPicOne" class="avatar">
          <i v-else class="el-icon-plus avatar-uploader-icon"></i>
        </el-upload>
        <el-upload
          style="display: inline-block; margin-left: 20px"
          class="avatar-uploader"
          action="https://api-wechat-mall.ghovos.com/upload/file"
          :show-file-list="false"
          :on-success="handleSecondSuccess"
          :before-upload="beforeMainUpload"
        >
          <img v-if="goods.goodsPicTwo" :src="goods.goodsPicTwo" class="avatar">
          <i v-else class="el-icon-plus avatar-uploader-icon"></i>
        </el-upload>
        <el-upload
          style="display: inline-block; margin-left: 20px"
          class="avatar-uploader"
          action="https://api-wechat-mall.ghovos.com/upload/file"
          :show-file-list="false"
          :on-success="handleThirdSuccess"
          :before-upload="beforeMainUpload"
        >
          <img v-if="goods.goodsPicThree" :src="goods.goodsPicThree" class="avatar">
          <i v-else class="el-icon-plus avatar-uploader-icon"></i>
        </el-upload>
      </el-form-item>
      <br/>
      <Editor v-model="goods.goodsIntroduce"/>
      <el-form-item>
        <el-button type="primary" @click="onSubmit">提交</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
import goodsApi from '@/api/goods'
import Editor from '@/components/Editor'

export default {
  components: { Editor },
  data() {
    return {
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
      console.log(this.$route.query)
      this.goods.goodsId = this.$route.query.goods.goods_id
      this.goods.goodsName = this.$route.query.goods.goods_name
      this.goods.goodsIntroduce = this.$route.query.goods.goods_introduce
      this.goods.goodsPrice = this.$route.query.goods.goods_price
      this.goods.goodsNumber = this.$route.query.goods.goods_number
      this.goods.goodsWeight = this.$route.query.goods.goods_weight
      this.goods.goodsCatThreeId = this.$route.query.goods.goods_cat_three_id
      this.goods.goodsBigLogo = this.$route.query.goods.goods_big_logo
      this.goods.goodsPicOne = this.$route.query.goods.goods_pic_one
      this.goods.goodsPicTwo = this.$route.query.goods.goods_pic_two
      this.goods.goodsPicThree = this.$route.query.goods.goods_pic_three
      this.catArr = [
        this.$route.query.goods.goods_cat_one_id,
        this.$route.query.goods.goods_cat_two_id,
        this.$route.query.goods.goods_cat_three_id]
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
    handleFirstSuccess(res, file) {
      this.goods.goodsPicOne = res.data.url
    },
    handleSecondSuccess(res, file) {
      this.goods.goodsPicTwo = res.data.url
    },
    handleThirdSuccess(res, file) {
      this.goods.goodsPicThree = res.data.url
    },
    beforeMainUpload(file) {
      const isLt2M = file.size / 1024 / 1024 < 10

      if (!isLt2M) {
        this.$message.error('上传图片大小不能超过 10MB!')
      }
      return isLt2M
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
