<template>
  <div>
    <el-table
        :data="this.tabledatas"
        style="width: 100%"
        default-expand-all
        ref="multipleTable">
      <el-table-column
          type="selection"
          width="55">
      </el-table-column>
      <el-table-column type="expand">
        <template slot-scope="scope">
          <el-table class="demo-table-expand"
                    :data="scope.row.goods"
                    border
                    style="width: 100%">
            <el-table-column
                prop="good_small_logo"
                label="商品照片"
                width="300">
            </el-table-column>
            <el-table-column
                prop="goods_name"
                label="商品名字">
            </el-table-column>
            <el-table-column
                prop="goods_price"
                label="商品单价"
                width="100"
            >
            </el-table-column>
            <el-table-column
                prop="goods_number"
                label="商品数量"
                width="150"
            >
            </el-table-column>
            <el-table-column
                prop="goods_total_price"
                label="商品总价"
                width="150">
<!--              <template slot-scope="scope">-->
<!--              {{scope.row.all_prices=scope.row.goods_number*scope.row.goods_price}}-->
<!--            </template>-->
            </el-table-column>
          </el-table>
        </template>
      </el-table-column>
      <el-table-column align="center"
                       label="订单编号"
                       prop="order_number">
      </el-table-column>
      <el-table-column align="center"
                       label="下单时间"
                       prop="create_time">
      </el-table-column>
      <el-table-column align="center" label="操作" width="120">
        <template slot-scope="scope">
          <el-button size="small" type="success" @click="Payment(scope.row)">支付
          </el-button>
        </template>
      </el-table-column>
    </el-table>
    <el-col>
      <el-button @click="toggleSelection()">取消选择</el-button>
    </el-col>
  </div>
</template>

<script>
export default {


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
    Payment(row) {
      console.log(row)
    },
  },
  data() {
    return {
      multipleSelection: [],
      tabledatas:[]
    }
  }

}


</script>