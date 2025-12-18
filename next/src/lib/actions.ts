"use server";

import axios from "axios";
import { cookies, headers } from 'next/headers'

export const login = async (data:FormData) =>{
  try{
    const res = await axios.post(`${process.env.API_BASE_URL}/api/login`,
      {
        email: data.get("email"),
        password: data.get("password"),
      },
      {
        headers: {
          "Content-Type": "application/json",
        },
      }
    );
    const token:string = res.data.token;
    const cookieStore = await cookies();
    cookieStore.set({
      name: "token",
      value: token,
      httpOnly: true,
    });
  }catch(e){
    console.log(e);
    throw new Error("EmailまたはPasswordに誤りがあります");
  }  
}

export const getUserData = async () =>{
  try{
    const cookieStore = await cookies();
    const token:string|undefined = cookieStore.get("token")?.value;
    const res = await axios.get(`${process.env.API_BASE_URL}/api/user`,
      {
        headers:{
          "Content-Type": "application/json",
          "Authorization": `Bearer ${token}`
        },
        data:{}
      }
    )
    return res.data;
  }catch(e){
    console.log(e);
    throw new Error("アクセス許可がありません");
  }
}

export const logout = async () =>{
  try{
    const cookieStore = await cookies();
    const token:string|undefined = cookieStore.get("token")?.value;
    await axios.post(`${process.env.API_BASE_URL}/api/logout`,
      {},
      {
        headers: {
          "Content-Type": "application/json",
          "Authorization": `Bearer ${token}`
        },
      }
    );
    cookieStore.delete("token");
  }catch(e){
    console.log(e);
    throw new Error("ログアウトに失敗しました");
  }
}

export const register = async (data:FormData) => {
  try {
    await axios.post(`${process.env.API_BASE_URL}/api/register`,
      {
        name: data.get("user_name"),
        email: data.get("email"),
        password: data.get("password"),
      },
      {
        headers: {
          "Content-Type": "application/json",
        },
      }
    );
    await login(data);
  } catch (e) {
    console.log(e);
    throw new Error("ユーザー新規登録に失敗しました。");
  }
}

export const getXweet = async (userId?:number|null) => {
  try {
    let res;
    if(!userId) res = await axios.get(`${process.env.API_BASE_URL}/api/xweet`);
    else res = await axios.get(`${process.env.API_BASE_URL}/api/xweet?id=${userId}`);
    return res.data;
  } catch(e){
    console.log(e);
    throw new Error("Xweetの取得に失敗しました。");
  }
}

export const createXweet = async (data:FormData) => {
  try {
    const cookieStore = await cookies();
    const token:string|undefined = cookieStore.get("token")?.value;
    await axios.post(`${process.env.API_BASE_URL}/api/xweet/create`,
      {
        xweet: data.get("xweet"),
      },
      {
        headers:{
          "Content-Type": "application/json",
          "Authorization": `Bearer ${token}`,
        },
      }
    )
  } catch (e:any) {
    return e.response.data.message;
  }
}

export const canUpdateXweet = async (xweetId:number) => {
  try {
    const cookieStore = await cookies();
    const token:string|undefined = cookieStore.get("token")?.value;
    const res = await axios.get(`${process.env.API_BASE_URL}/api/xweet/update/${xweetId}`,
      {
        headers:{
          "Content-Type": "applocation/json",
          "Authorization": `Bearer ${token}`
        },
        data:{}
      }
    )
    return res.data;
  } catch (e) {
    console.log(e);
    throw new Error("更新許可がありません");
  }
}

export const updateXweet = async (data:FormData, xweetId:number) => {
  try {
    const cookieStore = await cookies();
    const token:string|undefined = cookieStore.get("token")?.value;
    await axios.put(`${process.env.API_BASE_URL}/api/xweet/update/${xweetId}`,
      {
        xweet: data.get("xweet"),
      },
      {
        headers:{
          "Content-Type": "application/json",
          "Authorization": `Bearer ${token}`,
        },
      }
    )
  } catch (e:any) {
    return e.response.data.message;
  }
}

export const deleteXweet = async (xweetId:number) => {
  try {
    const cookieStore = await cookies();
    const token:string|undefined = cookieStore.get("token")?.value;
    await axios.delete(`${process.env.API_BASE_URL}/api/xweet/delete/${xweetId}`,
      {
        headers:{
          "Content-Type": "application/json",
          "Authorization": `Bearer ${token}`,
        },
        data:{}
      }
    )
  } catch (e) {
    console.log(e);
    throw new Error("Xweet削除に失敗しました。");
  }
}

export const getFollows = async (userName:string) => {
  try {
    const cookieStore = await cookies();
    const token:string|undefined = cookieStore.get("token")?.value;
    const res = await axios.get(`${process.env.API_BASE_URL}/api/user/${userName}/follows`,
      {
        headers:{
          "Content-Type": "application/json",
          "Authorization": `Bearer ${token}`,
        },
        data:{}
      }
    )
    return res.data;
  } catch (e) {
    console.log(e);
    throw new Error("フォローユーザー取得に失敗しました。");
  }
}

export const getFollowers = async (userName:string) =>{
  try{
    const cookieStore = await cookies();
    const token:string|undefined = cookieStore.get("token")?.value;
    const res = await axios.get(`${process.env.API_BASE_URL}/api/user/${userName}/followers`,
      {
        headers:{
          "Content-Type": "application/json",
          "Authorization": `Bearer ${token}`
        },
        data:{}
      }
    )
    return res.data;
  }catch(e){
    console.log(e);
    throw new Error("フォロワー取得に失敗しました");
  }
}

export const getUserPage = async (userName:string,loginId?:number|null) =>{
  try{
    let res;
    if(!loginId) res = await axios.get(`${process.env.API_BASE_URL}/api/user/${userName}`);
    else res = await axios.get(`${process.env.API_BASE_URL}/api/user/${userName}?id=${loginId}`)
    return res.data;
  }catch(e){
    console.log(e);
    throw new Error("ユーザ情報取得に失敗しました");
  }
}

export const createFollow = async (userName:string) =>{
  try{
    const cookieStore = await cookies();
    const token:string|undefined = cookieStore.get("token")?.value;
    await axios.post(`${process.env.API_BASE_URL}/api/user/${userName}/follow`,
      {},
      {
        headers:{
          "Content-Type": "application/json",
          "Authorization": `Bearer ${token}`
        },
      }
    )
  }catch(e){
    console.log(e);
    throw new Error("フォローに失敗しました");
  }
}

export const deleteFollow = async (userName:string) =>{
  try{
    const cookieStore = await cookies();
    const token:string|undefined = cookieStore.get("token")?.value;
    await axios.delete(`${process.env.API_BASE_URL}/api/user/${userName}/unfollow`,
      {
        headers:{
          "Content-Type": "application/json",
          "Authorization": `Bearer ${token}`
        },
        data:{}
      }
    )
  }catch(e){
    console.log(e);
    throw new Error("フォロー解除に失敗しました");
  }
}

export const getMessages = async (chatId:number) =>{
  try{
    const cookieStore = await cookies();
    const token:string|undefined = cookieStore.get("token")?.value;
    const res = await axios.get(`${process.env.API_BASE_URL}/api/chat/${chatId}`,
      {
        headers:{
          "Content-Type": "application/json",
          "Authorization": `Bearer ${token}`
        },
        data:{}
      }
    );
    return res.data;
  }catch(e){
    console.log(e);
    throw new Error("メッセージ取得に失敗しました");
  }
}

export const createMessage = async (data:FormData, chatId:number) =>{
  try{
    const cookieStore = await cookies();
    const token:string|undefined = cookieStore.get("token")?.value;
    await axios.post(`${process.env.API_BASE_URL}/api/chat/${chatId}`,
      {
        message: data.get("message"),
      },
      {
        headers:{
          "Content-Type": "application/json",
          "Authorization": `Bearer ${token}`
        },
      }
    )
  }catch(error:any){
    return error.response.data.message;
  }
}

export const moveChatRoom = async (userName:string) =>{
  try{
    const cookieStore = await cookies();
    const token:string|undefined = cookieStore.get("token")?.value;
    const res = await axios.post(`${process.env.API_BASE_URL}/api/user/${userName}/chat`,
      {
        userName: userName,
      },
      {
        headers:{
          "Content-Type": "application/json",
          "Authorization": `Bearer ${token}`
        },
      }
    )
    return res.data;
  }catch(e){
    console.log(e);
    throw new Error("チャットルームへの移動に失敗しました");
  }
}