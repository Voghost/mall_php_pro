<template>
  <el-table :data="list" style="width: 100%;padding-top: 15px;">
    <el-table-column label="Goods_id" width="100">
      <template slot-scope="scope">
        {{ scope.row.goods_id}}
      </template>
    </el-table-column>
    <el-table-column label="Content" width="380" align="center">
      <template slot-scope="scope">
        {{ scope.row.content}}
      </template>
    </el-table-column>
    <el-table-column label="Star" width="200" align="center">
      <template slot-scope="scope">
        <el-rate disabled show-score v-model="scope.row.star"></el-rate>
      </template>
    </el-table-column>
  </el-table>
</template>

<script>
import echartApi from '@/api/echart'

export default {
  filters: {
    statusFilter(status) {
      const statusMap = {
        success: 'success',
        pending: 'danger'
      }
      return statusMap[status]
    }
  },
  data() {
    return {
      list: null
    }
  },
  created() {
    this.initComment()
  },
  methods: {
    initComment() {
      setInterval(this.fetchData, 20000)
      this.fetchData()
    },
    fetchData() {
      echartApi.getTenComment()
        .then(response => {
          console.log(response)
          this.list = response.data
      })
    }
  }
}
</script>
