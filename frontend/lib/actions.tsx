"use server"

import { cookies } from "next/headers"
import { redirect } from "next/navigation"

export async function setCookise(jwt: string) {
  cookies().set("jwt", jwt)
}

export async function checkLogin() {
  const jwt = cookies().get("jwt")?.value
  const url = `${process.env.NEXT_PUBLIC_BACKEND_URL}isLogged.php`
  const result = await fetch(url, {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify({ "jwt": jwt })
  })
  const data = await result.json()
  return data
}

export async function logout() {
  cookies().getAll().forEach((cookie) => {
    cookies().delete(cookie.name)
  })
  redirect("/")
}

export async function getTasks() {
  const jwt = cookies().get("jwt")?.value
  const url = `${process.env.NEXT_PUBLIC_BACKEND_URL}getTasks.php`
  const result = await fetch(url, {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify({ "jwt": jwt })
  })
  const data = await result.json()
  return data.tasks;
}

export async function addTask(taskContent: string) {
  const jwt = cookies().get("jwt")?.value
  const url = `${process.env.NEXT_PUBLIC_BACKEND_URL}addTask.php`
  const result = await fetch(url, {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify({ "jwt": jwt, "taskContent": taskContent })
  })
  const data = await result.json()
  return data;

}

export async function doneTask(taskId: number) {
  const jwt = cookies().get("jwt")?.value
  const url = `${process.env.NEXT_PUBLIC_BACKEND_URL}changeTaskStatus.php`
  const result = await fetch(url, {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify({ "jwt": jwt, "task_id": taskId })
  })
  const data = await result.json()
  return data;
}