import { UserController } from './controller/UserController'

export const Routes = [
  {
    method: 'post',
    route: '/signup',
    controller: UserController,
    action: 'save',
  },
  {
    method: 'get',
    route: '/users',
    controller: UserController,
    action: 'all',
  },
  {
    method: 'get',
    route: '/users/:id',
    controller: UserController,
    action: 'one',
  },
  {
    method: 'delete',
    route: '/users',
    controller: UserController,
    action: 'remove',
  },
]
