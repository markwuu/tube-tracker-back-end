import { getRepository } from 'typeorm'
import { NextFunction, Request, Response } from 'express'
import { User } from '../entity/User'
import * as bcrypt from 'bcrypt'

export class UserController {
  private userRepository = getRepository(User)

  async all(request: Request, response: Response, next: NextFunction) {
    return this.userRepository.find()
  }

  async one(request: Request, response: Response, next: NextFunction) {
    return this.userRepository.findOne(request.params.id)
  }

  async save(request: Request, response: Response, next: NextFunction) {
    const hash = bcrypt.hashSync(request.body.password, 10)
    return this.userRepository.save({
      email: request.body.email,
      password: hash,
    })
  }

  async remove(request: Request, response: Response, next: NextFunction) {
    await this.userRepository.remove(request.params.id)
  }
}
