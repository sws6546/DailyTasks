import type { Metadata } from "next";
import { Inter } from "next/font/google";
import "./globals.css";

const inter = Inter({ subsets: ["latin"] });

export const metadata: Metadata = {
  title: "projekt podsumowanie",
  description: "projekt podsumowanie na aplikacje internetowe",
};

export default function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  return (
    <html data-theme="dark" lang="pl">
      <body className={`${inter.className} w-full h-[100vh]`}>{children}</body>
    </html>
  );
}
