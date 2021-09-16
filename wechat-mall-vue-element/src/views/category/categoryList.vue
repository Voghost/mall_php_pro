<template>
  <div class="app-container">
    <el-form :inline="true" class="demo-form-inline">
      <el-form-item>
        <el-button type="primary" @click="getPreList">返回上一级</el-button>
      </el-form-item>
      <el-form-item>
        <el-button type="primary" @click="newCat">新增分类</el-button>
      </el-form-item>
    </el-form>
    <el-table :data="tableData" stripe border style="width: 100%">
      <el-table-column type="index" label="序号" width="51"/>
      <el-table-column prop="cat_name" label="分类名称" width="200">
      </el-table-column>
      <!--      <el-table-column prop="goodsIntroduce" label="商品介绍" width="200"/>-->
      <el-table-column label="分类图片" width="200">
        <template slot-scope="scope">
          <img v-if="scope.row.cat_icon" style="width: 160px" v-bind:src="scope.row.cat_icon" alt="分类图片">
        </template>
      </el-table-column>
      <el-table-column label="分类状态" width="120">
        <template slot-scope="scope">
          <div v-if="scope.row.cat_deleted===0">
            <i class="el-icon-upload2"/>显示
          </div>
          <div v-if="scope.row.cat_deleted===1">
            <i class="el-icon-download"/>隐藏
          </div>
        </template>
      </el-table-column>
      <el-table-column label="操作">
        <template slot-scope="scope">
          <el-button
            type="danger"
            size="mini"
            icon="el-icon-download"
            v-if="scope.row.cat_deleted===0"
            @click="updateState(scope.row.cat_id,1)"
          >
            隐藏
          </el-button>
          <el-button
            type="primary"
            size="mini"
            icon="el-icon-upload2"
            v-if="scope.row.cat_deleted===1"
            @click="updateState(scope.row.cat_id,0)"
          >
            显示
          </el-button>
          <el-button @click="edit(scope.row)">
            编辑
          </el-button>
          <el-button v-if="scope.row.cat_level <3" @click="getNextList(scope.row.cat_id)">
            下级分类管理
          </el-button>
        </template>
      </el-table-column>
    </el-table>
    <!-- 展示商品具体信息  -->
    <el-dialog title="分类编辑" :visible.sync="showCategory">
      <el-form :inline="true" :label-position="'top'" class="demo-form-inline">
        <el-form-item label="分类名字">
          <el-input v-model="currentCategory.cat_name" placeholder="请输入分类名字 *" required style="width: 400px"></el-input>
        </el-form-item>
        <br/>
        <el-form-item label="分类图片">
          <el-upload
            style="display: inline-block; margin-left: 20px"
            class="avatar-uploader"
            action="http://wechat_mall.php.test/upload/file"
            :show-file-list="false"
            :on-success="handleSuccess"
            :before-upload="beforeMainUpload"
          >
            <img width="80%"  v-if="currentCategory.cat_icon" :src="currentCategory.cat_icon" class="avatar">
            <i v-else class="el-icon-plus avatar-uploader-icon"></i>
          </el-upload>
        </el-form-item>
        <el-form-item>
          <el-button type="primary" @click="submitCat">提交</el-button>
        </el-form-item>
      </el-form>
    </el-dialog>
  </div>
</template>

<script>
import categoryApi from '@/api/category'

export default {
  data() {
    return {
      tableData: [],
      pid: 0,
      level: 1,
      tempPid: [],
      showCategory: false,
      currentCategory: {}
    }
  },
  created() {
    this.getCategory()
  },
  methods: {
    getCategory() {
      categoryApi.getCategory(this.level, this.pid)
        .then(res => {
          this.tableData = res.data
        })
        .catch(err => {
          console.log(err)
        })
    },
    updateState(cid, state) {
      categoryApi.updateState(cid, state)
        .then(res => {
          this.getCategory() // 刷新页面
          console.log(res)
        })
        .catch(err => {
          console.log(err)
        })
    },
    getNextList(cat_id) {
      this.tempPid[this.level - 1] = this.pid // 缓存
      console.log(this.tempPid)
      this.pid = cat_id
      this.level = this.level + 1
      this.getCategory()
    },
    getPreList() {
      if (this.level === 1) {
        this.$message('已经在最顶层')
      } else {
        this.pid = this.tempPid[this.level - 2]
        this.level = this.level - 1
        this.getCategory()
      }
    },
    saveOrUpdateCategory() {
      categoryApi.saveOrUpdateCategory(this.currentCategory)
        .then(res => {
          this.getCategory()
          console.log(res)
        })
        .catch(err => {
          console.log(err)
        })
    },
    submitCat() {
      this.saveOrUpdateCategory()
      this.showCategory = false
    },
    edit(cat) {
      this.showCategory = true
      this.currentCategory = cat
    },
    newCat() {
      this.showCategory = true
      this.currentCategory = {
        cat_icon: ''
      }
      this.currentCategory.cat_level = this.level
      this.currentCategory.cat_pid = this.pid
    },
    handleSuccess(res, file) {
      this.currentCategory.cat_icon = res.data.url
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

</style>
