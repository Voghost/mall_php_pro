<template>
  <!--未支付订单-->
  <div style="margin-top: 20px">
    <el-table
        ref="multipleTable"
        :data="tableData"
        tooltip-effect="dark"
        style="width: 100%">
      <el-table-column
          type="selection"
          width="50"
          style="margin: 50px">
      </el-table-column>
      <el-table-column
          prop="goods_image"
          label="商品图片"
          width="150">
      </el-table-column>
      <el-table-column
          prop="goods_name"
          label="商品名称"
          width="200">
      </el-table-column>
      <el-table-column
          prop="goods_price"
          label="商品单价"
          width="150">
      </el-table-column>
      <el-table-column
          prop="goods_number"
          label="商品数量"
          width="150">
      </el-table-column>
      <el-table-column
          prop="goods_prices"
          label="商品总价"
          width="150">
      </el-table-column>
      <el-table-column
          fixed="right"
          label="操作"
          width="200">
        <template slot-scope="scope">
          <el-button
              size="mini"
              @click="handleEdit(scope.$index, scope.row)">支付</el-button>
          <el-button
              size="mini"
              type="danger"
              @click="handleDelete(scope.$index, scope.row)">取消支付</el-button>
        </template>
      </el-table-column>
    </el-table>
    <el-button @click="toggleSelection()">取消选择</el-button>
    <el-button @click="gotoPayfor()">支付</el-button>
    <el-button @click="deletegoods()">取消支付</el-button>
  </div>
</template>

<script>
export default {
  data() {
    return {
      tableData: [{
        goods_image: '123',
        goods_name: '上海市普陀区金沙江路 1518 弄',
        goods_number: 2,
        goods_price: 123,
        goods_prices:2*123,
      }],
      multipleSelection: [],
    }
  },

  methods: {
    toggleSelection(rows) {
      if (rows) {
        rows.forEach(row => {
          this.$refs.multipleTable.toggleRowSelection(row);
        });
      } else {
        this.$refs.multipleTable.clearSelection();
      }
    },
    gotoPayfor(){
      window.location.href("http//www.baidu.com");
    },
    deletegood(){
      window.location.href("http//www.baidu.com");
    },


  }
}
</script>