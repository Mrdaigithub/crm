import * as types from './mutation-types'

export const mutations = {
  [types.SAVE_MENU](state,menu){
    state.menu = menu
  }
}
