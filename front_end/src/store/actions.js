import * as types from './mutation-types'

export const saveMenu = ({commit}, menu) =>{
  commit(types.SAVE_MENU,menu)
}
