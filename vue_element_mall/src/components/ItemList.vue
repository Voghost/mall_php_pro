<template>
  <div>
    <el-table
        :data="tableData"
        style="width: 100%;margin-bottom: 20px;"
        row-key="list_id"
        border
        default-expand-all
        :tree-props="{children: 'children', hasChildren: 'hasChildren'}">
      <el-table-column
          prop="list_id"
          label="订单编号"
          width="auto">
      </el-table-column>
      <el-table-column
          prop="list_add_time"
          label="下单时间"
          width="auto">
      </el-table-column>
      <el-table-column
          prop="goods_image"
          label="商品图片"
          width="auto">
      </el-table-column>
      <el-table-column
          prop="goods_name"
          label="商品名字">
      </el-table-column>
      <el-table-column
          prop="goods_number"
          label="商品数量">
      </el-table-column>
      <el-table-column
          prop="goods_state"
          label="订单状态">
      </el-table-column>
      <el-table-column
          prop="goods_price"
          label="商品价格">
      </el-table-column>
      <el-table-column
          fixed="right"
          label="操作"
          width="120">

      </el-table-column>
    </el-table>
  </div>
</template>
<script>
export default {
  data() {
    return {
      tableData: [{
        list_id: 122345,
        list_add_time: '2016-05-02',
        goods_image: '王小虎',
        goods_name: '上海市普陀区金沙江路 1518 弄',
        goods_number:2,
        goods_state:2,
        goods_price:123,
        opreate:1
      }, {
        list_id: 1345,
        list_add_time: '2017-05-02',
        goods_image: '王小虎',
        goods_name: '上海市普陀区金沙江路 1518 弄',
        goods_number:2,
        goods_state:2,
        goods_price:123,
      }, {
        list_id: 3,
        list_add_time: '2016-05-01',
        goods_price:1000,
        goods_number:2,
        children: [{
          list_id: '',
          list_add_time: '2016-05-01',
          goods_image: '王小虎',
          goods_name: '上海市普陀区金沙江路 1518 弄',
          goods_number:2,
          goods_state:2,
          goods_price:123,
        }, {
          list_id: '',
          list_add_time: '2016-05-01',
          goods_image: '王小虎',
          goods_name: '上海市普陀区金沙江路 1518 弄',
          goods_number:2,
          goods_state:2,
          goods_price:123,
        }]
      }, {
        list_id: 1345,
        list_add_time: '2017-05-02',
        goods_image: '王小虎',
        goods_name: '上海市普陀区金沙江路 1518 弄',
        goods_number:2,
        goods_state:2,
        goods_price:123,
      }]
    }
  },
}
</script>