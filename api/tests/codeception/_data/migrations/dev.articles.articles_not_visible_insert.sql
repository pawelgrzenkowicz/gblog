INSERT INTO articles (uuid, main_picture_uuid, categories, content_he, content_she, create_date, publication_date, ready_he, ready_she, removed, slug, title, views)
VALUES
    ('cd6014ca-5c3e-4a0d-a8ba-24b0d3be9c96', 'bb4b70a3-8911-41e6-99dd-058f445f9025', 'rodzina,malzenstwo', 'jego text', 'jej text', '1994-06-30 17:40:00', '2004-07-01 17:40:00', false, true, false, 'test-slug-01', 'test-tytuł-01', 0),
    ('df508751-d537-45db-a9e9-e6bb053e69c2', '53a1e35a-e544-44aa-bffd-fe066c00ff4d', 'rodzina,malzenstwo', 'jego text', 'jej text', '1994-06-30 17:40:00', '2004-06-29 17:40:00', true, false, false, 'test-slug-02', 'test-tytuł-02', 0),
    ('afed8de0-4a6a-4184-a42f-c9efc3efde6c', '8ace3334-8b9a-40c7-875f-1c26cd765853', 'rodzina,malzenstwo', 'jego text', 'jej text', '1994-06-30 17:40:00', '2004-07-02 17:40:00', true, true, true, 'test-slug-03', 'test-tytuł-03', 0),
    ('15981189-98a6-4a6b-90e6-99ace9000a91', '9ae5597f-dbaf-4864-9368-e470978cb3ab', 'rodzina,malzenstwo,praca', 'jego text', 'jej text', '1994-06-30 17:40:00', '2094-07-29 17:40:00', true, true, false, 'test-slug-04', 'test-tytuł-04', 0),
    ('85f142b0-d631-4370-9dff-ebae4dca09d5', '68d90d7b-3cb9-4188-807a-87cc404ced47', 'rodzina,malzenstwo', 'jego text', 'jej text', '1994-06-30 17:40:00', null, true, true, false, 'test-slug-05', 'test-tytuł-05', 0)
;
