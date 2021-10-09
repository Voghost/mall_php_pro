<template>
  <div class="app-container">
    <div style="margin-top: 20px;margin-left: 20px;margin-bottom: 20px">
      <el-button type="primary" icon="el-icon-document-add" @click="newFloor()">新增</el-button>
    </div>
    <el-table :data="tableData" stripe border style="width: 100%">
      <el-table-column prop="floor_id" label="楼层id" width="51"/>
      <el-table-column prop="floor_name" label="楼层名称" width="250"/>
      <!--      <el-table-column prop="goodsIntroduce" label="商品介绍" width="200"/>-->
      <el-table-column label="楼层主图片" width="350">
        <template slot-scope="scope">
          <img v-bind:src="scope.row.floor_image" alt="" style="width: 300px; height: auto">
        </template>
      </el-table-column>
      <el-table-column prop="floor_weight" label="楼层权重" width="100"/>
      <el-table-column label="操作">
        <template slot-scope="scope">
          <el-button type="success" icon="el-icon-edit-outline" @click="editFloor(scope.row)">修改</el-button>
          <el-button type="danger" icon="el-icon-document-delete" @click="removeById(scope.row.floor_id)">删除</el-button>
        </template>
      </el-table-column>
    </el-table>
    <el-dialog title="楼层编辑" :visible.sync="showFloor">
      <el-form :inline="true" :label-position="'top'" class="demo-form-inline">
        <el-form-item label="楼层图片">
          <el-upload
            style="display: inline-block; margin-left: 20px"
            class="avatar-uploader"
            action="https://api-wechat-mall.ghovos.com/upload/file"
            :show-file-list="false"
            :on-success="handleSuccess"
            :before-upload="beforeMainUpload"
          >
            <img v-if="floor.floor_image" :src="floor.floor_image" width="90%" class="avatar">
            <i v-else class="el-icon-plus avatar-uploader-icon"></i>
          </el-upload>
        </el-form-item>
        <br/>
        <el-form-item label="楼层名称">
          <el-input v-model="floor.floor_name" placeholder="请输入楼层名称" required style="width: 400px"></el-input>
        </el-form-item>
        <br/>
        <el-form-item label="楼层关键字(用于跳转)">
          <el-input v-model="floor.floor_keyword" placeholder="请输入楼层关键字" required style="width: 400px"></el-input>
        </el-form-item>
        <br/>
        <el-form-item label="楼层权重(用于排序)">
          <el-input v-model="floor.floor_weight" placeholder="请输入楼层权重" required style="width: 400px"></el-input>
        </el-form-item>
        <br/>
        <el-form-item>
          <el-button type="primary" @click="submitFloor">提交</el-button>
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
      searchObj: {},
      tableData: [],
      current: 1,
      total: 0,
      limit: 10,
      home: {},
      showFloor: false,
      floor: {}
    }
  },

  // 在渲染前运行
  created() {
    this.getList()
  },

  // 各种函数
  methods: {
    // 分页查询
    getList(page = 1) {
      this.current = page
      homeApi.allFloor()
        .then(response => {
          this.tableData = response.data.content
          this.total = response.data.total
        })
        .catch(error => {
          console.log(error)
        })
    },
    editFloor(floor) {
      this.showFloor = true
      this.floor = floor
    },
    removeById(id) {
      this.floor = {} // 置为空
      this.floor.floor_id = id
      console.log(this.floor)
      this.$confirm('此操作将删除楼层信息, 是否继续?', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      }).then(() => {
        // 调用接口

        homeApi.deleteFloor(this.floor)
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
    saveOrUpdateFloor() {
      homeApi.saveOrUpdateFloor(this.floor)
        .then(res => {
          console.log(res)
          this.showFloor = false
        })
        .catch(err => {
          console.log(err)
        })
    },
    submitFloor() {
      this.saveOrUpdateFloor()
    },
    newFloor() {
      this.showFloor = true
      this.floor = {}
    },
    handleSuccess(res, file) {
      this.floor.floor_image = res.data.url
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

<style scoped>

</style>
