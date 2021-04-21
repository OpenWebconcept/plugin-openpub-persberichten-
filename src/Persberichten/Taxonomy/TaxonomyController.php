<?php

namespace OWC\Persberichten\Taxonomy;

class TaxonomyController
{
    /**
     * Add meta input field to taxonomy add new form.
     *
     * @param string $taxonomy
     * 
     * @return void
     */
    public function addMailingListField(string $taxonomy): void
    {
        if ($taxonomy !== 'openpub_press_mailing_list') {
            return;
        }

        echo '<div class="form-field">
            <label for="openpub_press_mailing_list_id">' . __('Mailinglist ID', 'openpub-persberichten') . '</label>
            <input type="text" name="openpub_press_mailing_list_id" id="openpub_press_mailing_list_id" />
            <p>' . __('The id of the mailinglist in Laposta.', 'openpub-persberichten') . '</p>
            </div>';
    }

    /**
     * Add meta input field to taxonomy edit form.
     *
     * @param object $term
     * @param string $taxonomy
     * 
     * @return void
     */
    public function editMailingListField(object $term, string $taxonomy): void
    {
        if ($taxonomy !== 'openpub_press_mailing_list') {
            return;
        }

        $mailinglistID = get_term_meta($term->term_id, 'openpub_press_mailing_list_id', true);

        echo '<tr class="form-field">
            <td>
                <label for="openpub_press_mailing_list_id">' . __('Mailinglist ID', 'openpub-persberichten') . '</label>
            </td>
            <td>
                <input type="text" name="openpub_press_mailing_list_id" id="openpub_press_mailing_list_id" value="' . $mailinglistID . '" />
                <p>' . __('The id of the mailinglist in Laposta.', 'openpub-persberichten') . '</p>
            </td>
            </tr>';
    }

    /**
     * Add admin column header 'Mailinglist ID'.
     *
     * @param array $columns
     * 
     * @return array
     */
    public function mailingListAdminColumnHeader(array $columns): array
    {
        $columns['openpub_press_mailing_list_id'] = __('Mailinglist ID', 'openpub-persberichten');

        return $columns;
    }

    /**
     * Admin column value for 'Mailinglist ID'.
     *
     * @param string $html
     * @param string $columnName
     * @param int $taxID
     * 
     * @return string
     */
    public function mailingListAdminColumnValue(string $html, string $columnName, int $taxID): string
    {
        $maillingList = get_term($taxID, 'openpub_press_mailing_list');
        $meta         = get_term_meta($maillingList->term_id, 'openpub_press_mailing_list_id', true);

        return !empty($meta) ? $meta : 'onbekend';
    }

    public function saveMailingListField($termID): void
    {
        update_term_meta(
            $termID,
            'openpub_press_mailing_list_id',
            sanitize_text_field($_POST['openpub_press_mailing_list_id'])
        );
    }
}
