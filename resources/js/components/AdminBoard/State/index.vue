<template>
  <div>
   <state-table></state-table>
   <state-dialog></state-dialog>
  </div>
</template>

<script>
import table from './StateTable'
import dialog from './StateDialog'

export default {
  components:{
    'state-table':table,
    'state-dialog':dialog
  }
}
</script>

