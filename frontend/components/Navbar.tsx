"use client"

import { logout } from "@/lib/actions"
import Link from "next/link"

export default function Navbar() {
  const logoutHandler = () => {
    logout()
  }
  return (
    <nav className="navbar flex flex-row justify-between skeleton rounded-[100px] shadow-xl pl-4 pr-4">
      <Link href="/" className="btn btn-ghost text-2xl font-bold">DailyTasks</Link>
      <button onClick={() => logoutHandler()} className="btn btn-error">Wyloguj</button>
    </nav>
  )
}
