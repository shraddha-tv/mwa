<template>
  <div>
   <name-table></name-table>
   <name-dialog></name-dialog>
  </div>
</template>

<script>
import table from './GoodsNameTable'
import dialog from './GoodsNameDialog'

export default {
  components:{
    'name-table':table,
    'name-dialog':dialog
  }
}
</script>

