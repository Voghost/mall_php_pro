<template>
  <div>
    <el-table
        :data="list_info"
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
                prop="goods_image"
                label="商品照片"
                width="300"
            >
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
                prop="goods_prices"
                label="商品总价"
                width="150"
            >
            </el-table-column>
            <el-table-column
                prop="goods_state"
                width="150"
                label="状态">
            </el-table-column>
          </el-table>
        </template>
      </el-table-column>
      <el-table-column align="center"
                       label="订单编号"
                       prop="order_id">
      </el-table-column>
      <el-table-column align="center"
                       label="下单时间"
                       prop="order_create_time">
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
  created() {

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
    Payment(row) {
      console.log(row)
    },
  },
  data() {
    return {
      multipleSelection: [],
      list_info: [{
        order_id: 'S201841413227',
        order_create_time: '2016-05-03',
        goods: [{
          goods_image: '王小虎',
          goods_name: '你好',
          goods_price: 123,
          goods_number: 2,
          goods_prices: 2 * 123,
          goods_state: "待评价",
          goods_id: 123,
        },
          {
            goods_image: '王小虎',
            goods_name: '你好mua',
            goods_price: 123,
            goods_number: 2,
            goods_prices: 2 * 123,
            goods_state: "待评价",
            goods_id: 1234,
          }]
      },
        {
          order_id: 'S12456742194',
          order_create_time: '2016-05-03',
          goods: [{
            goods_image: '王小虎',
            goods_name: '20飞机杯一号',
            goods_price: 123,
            goods_number: 2,
            goods_prices: 2 * 123,
            goods_state: "已完成",
            goods_id: 1235,
          }]
        }],
    }
  }
}


</script>
