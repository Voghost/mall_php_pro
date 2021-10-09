<template>
  <div>
    <div style="margin-top: 20px;margin-left: 20px;margin-bottom: 20px">
      <el-button type="primary" icon="el-icon-document-add" @click="newSwiper()">新增</el-button>
<!--      <el-button type="success" icon="el-icon-edit-outline">修改</el-button>-->
<!--      <el-button type="danger" icon="el-icon-document-delete">删除</el-button>-->
    </div>
    <el-table
      ref="filterTable"
      :data="tableData"
      stripe border style="width: 100%"
      tooltip-effect="dark"
      :default-sort = "{prop: 'date', order: 'descending'}">
      <el-table-column label="商品Id" sortable width="90">
        <template slot-scope="scope">
          G{{ scope.row.goods_id }}
        </template>
      </el-table-column>
      <el-table-column label="轮播图" width="350">
        <template slot-scope="scope">
          <img v-bind:src="scope.row.image_src" alt="" style="width: 300px; height: auto">
        </template>
      </el-table-column>
      <el-table-column prop="navigator_url" label="跳转链接"/>
      <el-table-column label="操作">
        <template slot-scope="scope">
          <el-button type="success" icon="el-icon-edit-outline" @click="edit(scope.row)">修改</el-button>
          <el-button type="danger"  icon="el-icon-document-delete" @click="removeById(scope.row.swiper_id)">删除</el-button>
        </template>
      </el-table-column>
    </el-table>
    <el-dialog title="轮播图编辑" :visible.sync="showSwiper">
      <el-form :inline="true" :label-position="'top'" class="demo-form-inline">
        <el-form-item label="轮播图片">
          <el-upload
            style="display: inline-block; margin-left: 20px"
            class="avatar-uploader"
            action="https://api-wechat-mall.ghovos.com/upload/file"
            :show-file-list="false"
            :on-success="handleSuccess"
            :before-upload="beforeMainUpload"
          >
            <img v-if="swiper.image_src" :src="swiper.image_src" class="avatar" width="90%">
            <i v-else class="el-icon-plus avatar-uploader-icon"></i>
          </el-upload>
        </el-form-item>
        <br/>
        <el-form-item label="商品Id">
          <el-input v-model="swiper.goods_id" placeholder="请输入商品Id *" required style="width: 400px"></el-input>
        </el-form-item>
        <br/>
        <el-form-item>
          <el-button type="primary" @click="submitSwiper">提交</el-button>
        </el-form-item>
      </el-form>
    </el-dialog>
  </div>
</template>

<script>
import homeApi from '@/api/home'

export default {
  data() {
    return {
      tableData: [],
      current: 1,
      total: 0,
      limit: 10,
      home: {},
      showSwiper: false,
      swiper: {},
      multipleSelection: []
    }
  },

  created() {
    this.getList()
  },

  methods: {
    getList(page = 1) {
      this.current = page
      homeApi.allSwiper()
        .then(response => {
          this.tableData = response.data.content
          this.total = response.data.total
        })
        .catch(error => {
          console.log(error)
        })
    },
    edit(swiper) {
      this.showSwiper = true
      this.swiper = swiper
    },
    removeById(id) {
      this.swiper = {} // 置为空
      this.swiper.swiper_id = id
      console.log(this.swiper)
      this.$confirm('此操作将删除轮播图信息, 是否继续?', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      }).then(() => {
        // 调用接口

        homeApi.deleteSwiper(this.swiper)
          .then(response => {
            console.log(response)
            this.$message({
              type: 'success',
              message: '删除成功!'
            })
            this.current = 1
            this.getList(1) // 刷新页面
          })
      }).catch(() => {
        this.$message({
          type: 'info',
          message: '已取消删除'
        })
      })
    },
    saveOrUpdateSwiper() {
      homeApi.saveOrUpdateSwiper(this.swiper)
        .then(res => {
          console.log(res)
          this.showSwiper = false
        })
        .catch(err => {
          console.log(err)
        })
    },
    submitSwiper() {
      this.saveOrUpdateSwiper()
    },
    newSwiper() {
      this.showSwiper = true
      this.swiper = {}
    },
    handleSuccess(res, file) {
      this.swiper.image_src = res.data.url
    },
    beforeMainUpload(file) {
      const isLt2M = file.size / 1024 / 1024 < 10

      if (!isLt2M) {
        this.$message.error('上传图片大小不能超过 10MB!')
      }
      return isLt2M
    },
    test(num) {
      alert('hello' + num)
    }
  }
}
</script>
