import { Page, test, expect } from '@playwright/test'
import { testCreateUser, testLogin } from '../utils';
import { TEXT1 } from '../constants';

test.beforeEach(async ({ request }) => {
  await request.post(`${process.env.TEST_API_URL}/api/test/reset-db`);
});

test.afterEach(async ({ page }) => {
  await page.close();
});

const testCreateXweet = async(page: Page, xweet: string) =>{
  await page.goto(`${process.env.TEST_FRONT_URL}/xweet/create`);
  await page.locator('textarea').waitFor();
  await page.locator('#create-xweet').waitFor();
  await page.fill('textarea', xweet);
  await page.click('#create-xweet');
}

test('非ログイン時、Xweet投稿画面に移動するとログイン画面にリダイレクト', async ({ page }) => {
  const res = await page.goto(`${process.env.TEST_FRONT_URL}/xweet/create`);
  await page.waitForURL(`${process.env.TEST_FRONT_URL}/login`);
});

test('ログイン後、Xweet投稿画面に移動', async ({ page }) => {
  const user = await testCreateUser();
  await testLogin(page,user.email,'password');
  const res = await page.goto(`${process.env.TEST_FRONT_URL}/xweet/create`);
  expect(res?.status()).toBe(200);
});

test('ログイン後、Xweet投稿しレスポンスが返る', async ({ page }) => {
  const user = await testCreateUser();
  await testLogin(page,user.email,'password');
  await testCreateXweet(page,'Test Xweet');
  await page.waitForURL(`${process.env.TEST_FRONT_URL}/xweet`);
  await page.goto(`${process.env.TEST_FRONT_URL}/xweet`);
  await expect(page.locator('#xweet-content')).toContainText(['Test Xweet']);
});

test('ログイン後、バリデーションを満たさない内容は投稿できない', async ({ page }) => {
  const user = await testCreateUser();
  await testLogin(page,user.email,'password');
  await testCreateXweet(page,TEXT1);
  await expect(page).not.toHaveURL(`${process.env.TEST_FRONT_URL}/xweet`);
  await page.goto(`${process.env.TEST_FRONT_URL}/xweet`);
  await expect(page.locator('#xweet-content')).not.toContainText([TEXT1]);
});