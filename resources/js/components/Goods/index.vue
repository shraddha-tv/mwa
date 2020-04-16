<template>
  <div>
   <goods-table></goods-table>
   <goods-dialog></goods-dialog>
  </div>
</template>

<script>
import table from './GoodsTable'
import dialog from './GoodsDialog'

export default {
  components:{
    'goods-table':table,
    'goods-dialog':dialog
  }
}
</script>

