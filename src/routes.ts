import { UserController } from './controller/UserController'

export const Routes = [
  {
    method: 'post',
    route: '/signup',
    controller: UserController,
    action: 'signup',
  },
  {
    method: 'post',
    route: '/login',
    controller: UserController,
    action: 'login',
  },
]
